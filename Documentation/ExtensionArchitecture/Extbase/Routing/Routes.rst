:navigation-title: Defining routes

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Defining routes
..  _extbase-routing-routes:

===================================
Defining routes for Extbase plugins
===================================

Each entry in the :yaml:`routes` list of the
:ref:`Extbase plugin enhancer <extbase-routing-enhancer>` maps one
controller/action combination to a URL pattern. For an incoming request, TYPO3
tests the entries in order, and the first one that fits wins. To generate a
URL, TYPO3 sorts the entries first, see
:ref:`How route variants are matched <extbase-routing-enhancer-variants>`.

..  seealso::

    `Route Enhancements and Aspects — route configuration keys <https://docs.typo3.org/permalink/t3coreapi:routing-advanced-routing-configuration-enhancers>`_ —
    full reference for :yaml:`defaults`, :yaml:`requirements`, :yaml:`static`, and :yaml:`_arguments`.


..  _extbase-routing-routes-anatomy:

Anatomy of a route entry
========================

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/Main/route-enhancers.yaml

    routes:
      - routePath: '/{conference_slug}'
        _controller: 'Conference::show'
        _arguments:
          conference_slug: conference

:yaml:`routePath`
    The URL segment appended to the page slug. Static text and
    :samp:`{placeholder}` variables can be combined freely. A bare :samp:`/` matches
    the page URL with nothing appended — useful for the default action.

:yaml:`_controller`
    The controller/action pair in :samp:`ControllerName::actionName` format —
    no :php:`Action` suffix, no namespace. This tells TYPO3 which route to pick
    when generating a URL for that action, and which action to dispatch to
    when resolving an incoming request.

:yaml:`_arguments`
    Maps placeholder names in :yaml:`routePath` to Extbase argument names. In the
    example above, the URL segment captured by :samp:`{conference_slug}` is passed
    to the action as the argument named :yaml:`conference`. The action receives the
    raw URL value — typically a slug string like :samp:`typo3camp-2025`. An
    :ref:`aspect <extbase-routing-aspects>` on :yaml:`conference_slug` then
    translates that slug into the UID that Extbase uses to load the object.
    Without an aspect the raw string reaches the action unchanged.

    Omit :yaml:`_arguments` entirely when the placeholder name already matches the
    Extbase argument name.


..  _extbase-routing-routes-order:

Route order and specificity
===========================

For an incoming URL, routes are evaluated top to bottom, and the first route
that fits wins. A route does not fit if the URL does not match its
:yaml:`routePath` and :yaml:`requirements`, or if one of its
:ref:`aspects <extbase-routing-aspects>` cannot resolve the value taken from the
URL. TYPO3 then tries the next route.

A placeholder without an aspect and without a requirement accepts every value
of its URL segment. A route made of such a placeholder swallows the requests
meant for the routes after it.

Consider a plugin with a list action, a paginated list, and a detail action.
Given the page slug :samp:`/conferences`, the following URLs need to resolve
correctly:

*   :samp:`/conferences/` → :yaml:`Conference::list` (no arguments)
*   :samp:`/conferences/page-2` → :yaml:`Conference::list` with :yaml:`currentPage = 2`
*   :samp:`/conferences/typo3camp-2025` → :yaml:`Conference::show` with the resolved UID

With this route order, resolution works correctly:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/Main/route-enhancers.yaml

    routes:
      - routePath: '/'
        _controller: 'Conference::list'
      - routePath: '/page-{page}'
        _controller: 'Conference::list'
        _arguments:
          page: currentPage
      - routePath: '/{conference_slug}'
        _controller: 'Conference::show'
        _arguments:
          conference_slug: conference

If :yaml:`/{conference_slug}` had no aspect and were listed before
:yaml:`/page-{page}`, the request for :samp:`/conferences/page-2` would match
it. :yaml:`conference_slug` would receive the value :samp:`page-2`, and the
pagination route would never be reached.

With a :ref:`PersistedAliasMapper <extbase-routing-aspects-persisted-alias>`
on :yaml:`conference_slug`, as in the complete examples, the order is no longer
decisive for this URL: the mapper finds no conference with the slug
:samp:`page-2`, so TYPO3 skips the route and the pagination route matches.
Put routes with a static segment first all the same:

*   TYPO3 compares the static segment as a string, which rejects a URL without
    any further work. A :php-short:`\TYPO3\CMS\Core\Routing\Aspect\PersistedAliasMapper`
    queries the database for every URL it is asked to resolve.
*   If a value is valid for both routes, for example a conference with the slug
    :samp:`page-2`, the route listed first wins.

..  seealso::

    `The wrong route is used <https://docs.typo3.org/permalink/t3coreapi:routing-troubleshooting-ambiguous-routes>`_ —
    troubleshooting routes that fit the same URL.


..  _extbase-routing-routes-defaults:

Separate routes instead of defaults
===================================

The :yaml:`defaults` key at enhancer level makes a placeholder optional: an
incoming URL may leave it out, and TYPO3 fills in the default value. When
generating a URL, TYPO3 leaves out a placeholder whose value is the default,
but only the placeholder. The static text of the route path stays in the URL.

With :yaml:`defaults` set to :yaml:`page: '1'`, the route
:yaml:`/page-{page}` therefore generates :samp:`/conferences/page` for the
first page. TYPO3 tries a route with placeholders before the route :yaml:`/`,
see :ref:`How route variants are matched <extbase-routing-enhancer-variants>`.
So even a link to the list without any page argument gets
:samp:`/conferences/page` instead of :samp:`/conferences/`.

A default value also reaches the action. With :yaml:`month: ''` as default, a
request for :samp:`/conferences/2025` passes an empty month to the action.

Configure one route for each combination of arguments instead, and leave out
:yaml:`defaults`:

..  literalinclude:: _snippets/_routes-pagination.yaml
    :caption: EXT:my_extension/Configuration/Sets/Main/route-enhancers.yaml
    :emphasize-lines: 10-15

*   A link to the list without :yaml:`currentPage` only fits the route
    :yaml:`/`, because :yaml:`/page-{page}` needs a value for its placeholder.
    It generates :samp:`/conferences/`.
*   A link with :yaml:`currentPage` set to `2` generates
    :samp:`/conferences/page-2`.

A link with :yaml:`currentPage` set to `1` generates
:samp:`/conferences/page-1`, a second URL for the first page. The pagination
template could leave out the argument for the first page. The action then
uses the default value of its parameter:

..  literalinclude:: _snippets/_pagination-first-page.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/List.fluid.html (excerpt)

..  seealso::

    `The wrong route is used <https://docs.typo3.org/permalink/t3coreapi:routing-troubleshooting-ambiguous-routes>`_ —
    how :yaml:`defaults` make a route fit a link that does not supply all of
    its arguments.


..  _extbase-routing-routes-requirements:

Constraining placeholders with requirements
===========================================

:yaml:`requirements` defines a regular expression per placeholder. A route only
matches an incoming URL segment if it satisfies the requirement; without a
requirement, any string matches.

In the full example below, :yaml:`page: '\d+'` limits the pagination route to
digits: :samp:`/conferences/page-2` fits it, :samp:`/conferences/page-two` does
not.

A requirement alone does not remove `cHash` from the generated URL, however
strict it is. In the example, the
:ref:`StaticRangeMapper <extbase-routing-aspects-static-range>` makes
:yaml:`page` static. A placeholder without an aspect needs a :yaml:`static`
declaration in addition to its requirement, see
:ref:`The cHash parameter <extbase-routing-enhancer-chash>`.

A requirement also applies to a placeholder that has an aspect. It is checked
against the value in the URL, such as a slug, not against the value the action
receives, such as a UID. See
:ref:`Aspects and requirements together <extbase-routing-aspects-precedence>`.

..  literalinclude:: _snippets/_routes-pagination.yaml
    :caption: EXT:my_extension/Configuration/Sets/Main/route-enhancers.yaml
    :emphasize-lines: 20-21

The next step is configuring the :yaml:`aspects` entries that translate
placeholder values into human-readable URL segments — see
:ref:`Routing aspects <extbase-routing-aspects>`.
