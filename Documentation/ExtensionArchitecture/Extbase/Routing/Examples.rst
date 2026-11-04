:navigation-title: Routing examples

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Routing examples
..  _extbase-routing-examples:

====================================
Routing examples and common mistakes
====================================

The following examples build on the concepts explained in the preceding pages.
Each is a complete, working configuration you can adapt directly.

..  contents:: On this page
    :local:


..  _extbase-routing-examples-list-detail:

List, pagination, and detail
============================

The most common Extbase plugin pattern: a list page with pagination and a detail
view. The list and detail actions are on the same page here; for separate pages
see
:ref:`List and detail on separate pages
<extbase-routing-examples-separate-pages>`.

**URLs produced:**

*   :samp:`/conferences/` — list, first page
*   :samp:`/conferences/page-2` — list, page 2
*   :samp:`/conferences/typo3camp-2025` — detail view

..  literalinclude:: _snippets/_example-list-detail.yaml
    :caption: EXT:my_extension/Configuration/Sets/Main/route-enhancers.yaml

Key points:

*   The pagination route :yaml:`/page-{page}` uses a static prefix :yaml:`page-`
    to distinguish it from the detail route :yaml:`/{conference_slug}`. TYPO3
    rejects a URL without this prefix by a string comparison, before any aspect
    is asked. The prefix also keeps the routes apart for a conference whose slug
    is a number, such as :samp:`2025`.
*   The first page has its own route :yaml:`/` and no :yaml:`defaults` entry
    for :yaml:`page`. A link without :yaml:`currentPage` generates
    :samp:`/conferences/` — see
    :ref:`Separate routes instead of defaults <extbase-routing-routes-defaults>`.
*   :yaml:`fallbackValue: null` on the :yaml:`PersistedAliasMapper` means a
    deleted or hidden conference returns :php:`null` to the action rather than a
    404. The action must declare the argument nullable and handle it explicitly
    — see
    :ref:`Handling deleted or hidden records
    <extbase-routing-aspects-fallback>`.
*   Route order matters: pagination before detail, most specific before most
    general — see
    :ref:`Route order and specificity <extbase-routing-routes-order>`.


..  _extbase-routing-examples-separate-pages:

List and detail on separate pages
=================================

When the list plugin and the detail plugin live on different pages, each page
needs its own enhancer entry — :yaml:`limitToPages` must point to the correct
page for each, and links between them need :php:`setTargetPageUid()` or
:html:`pageUid` in Fluid.

..  literalinclude:: _snippets/_example-separate-pages.yaml
    :caption: EXT:my_extension/Configuration/Sets/Main/route-enhancers.yaml

In the list template, link to the detail page explicitly:

..  literalinclude:: _snippets/_example-list-link.fluid.html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/List.fluid.html

Store the detail page UID in TypoScript settings so it is configurable
without touching PHP:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/Sets/Main/setup.typoscript

    plugin.tx_myextension_conferences.settings.detailPageUid = 42


..  _extbase-routing-examples-multi-controller:

Multiple controllers in one plugin
==================================

A single plugin can expose actions from more than one controller — all under
the same namespace, all in one enhancer. The key is that every controller/action
combination that needs a clean URL gets its own route entry.

**URLs produced:**

*   :samp:`/conferences/` — conference list
*   :samp:`/conferences/typo3camp-2025` — conference detail
*   :samp:`/conferences/typo3camp-2025/talks` — talk list for that conference
*   :samp:`/conferences/typo3camp-2025/talks/extbase-routing-demystified` — talk detail

..  literalinclude:: _snippets/_example-multi-controller.yaml
    :caption: EXT:my_extension/Configuration/Sets/Main/route-enhancers.yaml

The :yaml:`{conference_slug}` placeholder appears in both the
:yaml:`Conference::show` route and the :yaml:`Talk` routes. Each is a separate
route entry with its own :yaml:`_controller` — the enhancer matches on the full
path and controller/action combination, not on the placeholder name alone.


..  _extbase-routing-examples-date-filter:

Date-based conference archive
=============================

Filter the conference list by year and month using human-readable URL segments.
Each combination of arguments has its own route entry, so the configuration
needs no :yaml:`defaults`: a link with a year only fits :yaml:`/{year}`, a link
with a year and a month fits :yaml:`/{year}/{month}`.

The link has to pass the month in the format of the :yaml:`map`, such as `03`.
For the value `3` the :yaml:`StaticValueMapper` finds no entry, and TYPO3
appends the month as a query parameter instead.

**URLs produced:**

*   :samp:`/conferences/2025/march` — conferences in March 2025
*   :samp:`/conferences/2025/march/page-2` — paginated
*   :samp:`/conferences/2025` — all conferences in 2025

..  literalinclude:: _snippets/_example-date-archive.yaml
    :caption: EXT:my_extension/Configuration/Sets/Main/route-enhancers.yaml

..  warning::

    TYPO3 limits the number of values a route can produce, to guard against
    brute-force requests and cache flooding:

    *   A single :yaml:`StaticRangeMapper` accepts at most 1000 values.
        TYPO3 throws a :php:`\LengthException` for a larger range between
        :yaml:`start` and :yaml:`end`.
    *   TYPO3 multiplies the number of values of all :yaml:`StaticRangeMapper`
        and :yaml:`StaticValueMapper` aspects used in one route. If the product
        is larger than 10000, generating or resolving a URL of this route
        throws an :php:`\OverflowException`.

    The route :yaml:`/{year}/{month}/page-{page}` above combines 31 years,
    12 months, and 25 pages, which makes 9300 combinations. With 50 pages it
    would be 18600, and every URL of this route would fail. For a wider span,
    narrow another range, or write a custom mapper that does not implement
    :php:`\Countable`.

    ..  seealso::

        `Possible range of all mappers is larger than 10000 items <https://docs.typo3.org/permalink/t3coreapi:routing-troubleshooting-mapper-range>`_


..  _extbase-routing-examples-custom-aspects:

Beyond built-in aspects
=======================

The four built-in aspect types —
:ref:`PersistedAliasMapper <extbase-routing-aspects-persisted-alias>`,
:ref:`PersistedPatternMapper <extbase-routing-aspects-persisted-pattern>`,
:ref:`StaticValueMapper <extbase-routing-aspects-static-value>`, and
:ref:`StaticRangeMapper <extbase-routing-aspects-static-range>` — cover the
majority of real-world cases. When they do not, TYPO3 allows extensions to
register fully custom aspect classes. A good example is
:composer:`georgringer/news`, which ships its own :yaml:`NewsTitle`,
:yaml:`NewsCategory`, and :yaml:`NewsTag` mappers — all thin wrappers around
:php-short:`\TYPO3\CMS\Core\Routing\Aspect\PersistedAliasMapper`
that add extension-specific defaults and fallback handling.

..  seealso::

    `Route Enhancements and Aspects <https://docs.typo3.org/permalink/t3coreapi:routing-advanced-routing-configuration>`_ —
    the Core routing reference covers custom aspect registration.


..  _extbase-routing-examples-mistakes:

Common mistakes
===============

**Plugin not placed on the target page**
    The enhancer is configured, the URL looks right, but TYPO3 returns a 404.
    Check that the plugin content element is actually present on the page
    referenced in :yaml:`limitToPages`.

**setTargetPageUid() missing**
    Links from a list plugin point back to the list page instead of the detail
    page. Always set :php:`setTargetPageUid()` in PHP or :html:`pageUid` in
    Fluid when list and detail are on separate pages.

**Wrong route order**
    A placeholder route without an aspect (:yaml:`/{slug}`) is listed before
    a more specific route (:yaml:`/page-{page}`). The placeholder accepts every
    value, so the specific route is never reached. Add an aspect, and list the
    routes with a static segment first — see
    :ref:`Route order and specificity <extbase-routing-routes-order>`.

**limitToPages missing**
    Without :yaml:`limitToPages`, TYPO3 evaluates the enhancer for every page
    on the site. Performance degrades and unintended matches on unrelated pages
    become possible.

**URL ends in /page instead of the list URL**
    The enhancer sets :yaml:`defaults` for the page placeholder of a route
    like :yaml:`/page-{page}`. TYPO3 leaves out the default value, but not the
    static text, and uses this route even for a link without a page argument.
    Remove the :yaml:`defaults` entry and keep the route :yaml:`/` for the
    first page — see
    :ref:`Separate routes instead of defaults <extbase-routing-routes-defaults>`.

**cHash still appearing**
    A placeholder has a :yaml:`requirements` regex but neither an aspect nor a
    :yaml:`static` declaration. A regex requirement alone does not suppress
    `cHash`. Add an aspect, or declare the placeholder in :yaml:`static` — see
    :ref:`The cHash parameter <extbase-routing-enhancer-chash>`.

**Stale cache after config changes**
    Site configuration is cached. After any change to
    :file:`EXT:my_extension/Configuration/Sets/Main/route-enhancers.yaml`
    or :file:`config/sites/<site-identifier>/config.yaml`, clear all caches
    via :guilabel:`Admin Tools > Maintenance`.


..  _extbase-routing-examples-troubleshooting:

When a route does not behave as expected
========================================

A route enhancer that does not fit a URL or a link rarely raises an error.
TYPO3 tries the next route and, in the end, uses the plain page URL. The
symptom is a page where a 404 error was expected, or a URL that still contains
query parameters.

..  tip::

    The `troubleshooting page of the routing chapter <https://docs.typo3.org/permalink/t3coreapi:routing-troubleshooting>`_
    is organised by symptom and applies to Extbase plugins as well:

    *   `An invalid URL shows a page instead of a 404 error <https://docs.typo3.org/permalink/t3coreapi:routing-troubleshooting-missing-404>`_
    *   `A generated URL still contains query parameters <https://docs.typo3.org/permalink/t3coreapi:routing-troubleshooting-query-parameters>`_
    *   `An optional variable does not work with the PageType decorator <https://docs.typo3.org/permalink/t3coreapi:routing-troubleshooting-optional-variable>`_
    *   `The wrong route is used <https://docs.typo3.org/permalink/t3coreapi:routing-troubleshooting-ambiguous-routes>`_
    *   `Only the last enhancer of an Extbase plugin works <https://docs.typo3.org/permalink/t3coreapi:routing-troubleshooting-same-plugin>`_
    *   `Possible range of all mappers is larger than 10000 items <https://docs.typo3.org/permalink/t3coreapi:routing-troubleshooting-mapper-range>`_
