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

The most common Extbase plugin pattern: a list page with pagination and a
detail view. The list and detail actions are on the same page here; for
separate pages see :ref:`extbase-routing-examples-separate-pages`.

**URLs produced:**

*   :samp:`/conferences/` — list, first page
*   :samp:`/conferences/page-2` — list, page 2
*   :samp:`/conferences/typo3camp-2025` — detail view

..  literalinclude:: _snippets/_example-list-detail.yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

Key points:

*   The pagination route :yaml:`/page-{page}` uses a static prefix :yaml:`page-`
    to distinguish it from the detail route :yaml:`/{conference_slug}`. Without
    the prefix, :samp:`/conferences/page-2` would match the detail route first
    and try to resolve ``page-2`` as a conference slug.
*   :yaml:`fallbackValue: null` on the :yaml:`PersistedAliasMapper` means a
    deleted or hidden conference returns :php:`null` to the action rather
    than a 404. The action must declare the argument nullable and handle it
    explicitly — see :ref:`extbase-routing-aspects-fallback`.
*   Route order matters: pagination before detail, most specific before most
    general — see :ref:`extbase-routing-routes-order`.


..  _extbase-routing-examples-separate-pages:

List and detail on separate pages
=================================

When the list plugin and the detail plugin live on different pages, each page
needs its own enhancer entry — :yaml:`limitToPages` must point to the correct
page for each, and links between them need :php:`setTargetPageUid()` or
:html:`pageUid` in Fluid.

..  literalinclude:: _snippets/_example-separate-pages.yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

In the list template, link to the detail page explicitly:

..  literalinclude:: _snippets/_example-list-link.html
    :caption: EXT:my_extension/Resources/Private/Templates/Conference/List.fluid.html

Store the detail page UID in TypoScript settings so it is configurable
without touching PHP:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

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
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

The :yaml:`{conference_slug}` placeholder appears in both the
:yaml:`Conference::show` route and the :yaml:`Talk` routes. Each is a separate
route entry with its own :yaml:`_controller` — the enhancer matches on the full
path and controller/action combination, not on the placeholder name alone.


..  _extbase-routing-examples-date-filter:

Date-based conference archive
=============================

Filter the conference list by year and month using human-readable URL segments.
Each combination of arguments needs its own route entry because TYPO3 cannot
derive missing arguments from partial matches.

**URLs produced:**

*   :samp:`/conferences/2025/march` — conferences in March 2025
*   :samp:`/conferences/2025/march/page-2` — paginated
*   :samp:`/conferences/2025` — all conferences in 2025

..  literalinclude:: _snippets/_example-date-archive.yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

..  warning::

    The total number of possible value combinations across all
    :yaml:`StaticRangeMapper` aspects in one enhancer must not exceed 10,000.
    Multiply the ranges to check: 31 years × 12 months × 50 pages = 18,600 —
    that exceeds the limit. Reduce the page range or the year span accordingly.


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
    A catch-all placeholder route (:yaml:`/{slug}`) is listed before a more
    specific route (:yaml:`/page-{page}`). The catch-all matches first and the
    specific route is never reached. Most-specific routes must come first —
    see :ref:`extbase-routing-routes-order`.

**limitToPages missing**
    Without :yaml:`limitToPages`, TYPO3 evaluates the enhancer for every page
    on the site. Performance degrades and unintended matches on unrelated pages
    become possible.

**cHash still appearing**
    A placeholder has a :yaml:`requirements` regex but no aspect. Only
    :yaml:`StaticRangeMapper` and :yaml:`StaticValueMapper` mark a parameter
    as static and suppress :yaml:`cHash`. A regex requirement alone does not.

**Stale cache after config changes**
    Site configuration is cached. After any change to
    :file:`EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml`
    or :file:`config/sites/<site-identifier>/config.yaml`, clear all caches
    via :guilabel:`Admin Tools > Maintenance`.
