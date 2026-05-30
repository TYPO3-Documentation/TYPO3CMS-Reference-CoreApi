:navigation-title: Defining routes

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Defining routes
..  _extbase-routing-routes:

===================================
Defining routes for Extbase plugins
===================================

Each entry in the :yaml:`routes` list of the
:ref:`Extbase plugin enhancer <extbase-routing-enhancer>` maps one
controller/action combination to a URL pattern. TYPO3 tries each entry in
order — first match wins, both for incoming requests and for URL generation.

..  seealso::

    `Route Enhancements and Aspects — route configuration keys <https://docs.typo3.org/permalink/t3coreapi:routing-advanced-routing-configuration-enhancers>`_ —
    full reference for ``defaults``, ``requirements``, ``static``, and ``_arguments``.


..  _extbase-routing-routes-anatomy:

Anatomy of a route entry
========================

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

    routes:
        - routePath: '/{conference_slug}'
          _controller: 'Conference::show'
          _arguments:
              conference_slug: conference

``routePath``
    The URL segment appended to the page slug. Static text and
    ``{placeholder}`` variables can be combined freely. A bare ``/`` matches
    the page URL with nothing appended — useful for the default action.

``_controller``
    The controller/action pair in ``ControllerName::actionName`` format —
    no ``Action`` suffix, no namespace. This tells TYPO3 which route to pick
    when generating a URL for that action, and which action to dispatch to
    when resolving an incoming request.

``_arguments``
    Maps placeholder names in ``routePath`` to Extbase argument names. In the
    example above, the URL segment captured by ``{conference_slug}`` is passed
    to the action as the argument named ``conference``. The action receives the
    raw URL value — typically a slug string like ``typo3camp-2025``. An
    :ref:`aspect <extbase-routing-aspects>` on ``conference_slug`` then
    translates that slug into the UID that Extbase uses to load the object.
    Without an aspect the raw string reaches the action unchanged.

    Omit ``_arguments`` entirely when the placeholder name already matches the
    Extbase argument name.


..  _extbase-routing-routes-order:

Route order and specificity
===========================

Routes are evaluated top to bottom. The first entry whose :yaml:`routePath`
pattern and :yaml:`_controller` both match wins. This means a general placeholder
route can accidentally swallow requests meant for a more specific route if it
appears first.

Consider a plugin with a list action, a paginated list, and a detail action.
Given the page slug ``/conferences``, the following URLs need to resolve
correctly:

*   :samp:`/conferences/` → :yaml:`Conference::list` (no arguments)
*   :samp:`/conferences/page/2` → :yaml:`Conference::list` with :yaml:`currentPage = 2`
*   :samp:`/conferences/typo3camp-2025` → :yaml:`Conference::show` with ``conference = <uid>``

With this route order, resolution works correctly:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

    routes:
        - routePath: '/'
          _controller: 'Conference::list'
        - routePath: '/page/{page}'
          _controller: 'Conference::list'
          _arguments:
              page: currentPage
        - routePath: '/{conference_slug}'
          _controller: 'Conference::show'
          _arguments:
              conference_slug: conference

If :yaml:`/{conference_slug}` were listed first, the request for
:samp:`/conferences/page/2` would match it — ``conference_slug`` would receive the value ``page`` and the pagination route
would never be reached. The slug ``typo3camp-2025`` and the static segment
``page`` are both just strings to
the router; order is what distinguishes them.


..  _extbase-routing-routes-defaults:

Making path segments optional with defaults
===========================================

The :yaml:`defaults` key at enhancer level makes a placeholder optional. When the
generated URL would contain the default value, that segment is omitted entirely.

In the full example below, :yaml:`page: '1'` means a link to page 1 of the
list produces :samp:`/conferences/` rather than :samp:`/conferences/page/1`.
A link to page 2 still produces :samp:`/conferences/page/2`.

..  literalinclude:: _snippets/_routes-defaults.yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml
    :emphasize-lines: 16-17


..  _extbase-routing-routes-requirements:

Constraining placeholders with requirements
===========================================

``requirements`` defines a regular expression per placeholder. A route only
matches an incoming URL segment if it satisfies the requirement; without a
requirement, any string matches.

In the full example below, :yaml:`page: '\d+'` ensures that
:samp:`/conferences/page/2` matches the pagination route while
:samp:`/conferences/typo3camp-2025` does not — because ``typo3camp-2025``
is not all digits, so the pagination route is skipped and the detail route
matches instead.

Strict requirements also affect URL generation: combined with a
:ref:`StaticRangeMapper <extbase-routing-aspects-static-range>` aspect, they
allow TYPO3 to treat the parameter as static and omit ``cHash`` from the
generated URL.

Note that :yaml:`requirements` are ignored for any placeholder that has a
corresponding :yaml:`aspects` entry — the aspect takes precedence.

..  literalinclude:: _snippets/_routes-defaults.yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml
    :emphasize-lines: 18-19

The next step is configuring the :yaml:`aspects` entries that translate placeholder
values into human-readable URL segments — see :ref:`extbase-routing-aspects`.
