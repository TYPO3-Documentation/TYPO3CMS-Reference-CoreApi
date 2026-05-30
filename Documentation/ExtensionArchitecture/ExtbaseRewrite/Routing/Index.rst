:navigation-title: Routing

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Routing
..  _extbase-routing:

===========================
Routing for Extbase plugins
===========================

Without routing configuration, every Extbase plugin action produces URLs
with a namespaced query string:

..  code-block:: none

    https://example.org/conferences?tx_myextension_conferences[action]=show&tx_myextension_conferences[controller]=Conference&tx_myextension_conferences[conference]=42&cHash=…

Routing configuration transforms these into readable, :abbr:`SEO (Search Engine Optimisation)`-friendly URLs:

..  code-block:: none

    https://example.org/conferences/typo3camp-2025

TYPO3's routing system is built on top of Symfony routing components. The
Extbase plugin enhancer is a specialised layer on top — it handles the
controller/action namespace automatically. Understanding the general
TYPO3 routing concepts first makes Extbase routing much easier to follow.

..  seealso::

    *   `Routing — readable, SEO-friendly URLs <https://docs.typo3.org/permalink/t3coreapi:routing>`_ —
        overview of TYPO3 routing, terminology (slug, enhancer, aspect), and page-based routing.

    *   `Route Enhancements and Aspects <https://docs.typo3.org/permalink/t3coreapi:routing-advanced-routing-configuration>`_ —
        the full reference for all enhancer types and aspects available in TYPO3 Core.


How TYPO3 routing works with Extbase
====================================

TYPO3 resolves a request in two stages:

1. **Page routing** — maps the URL path to a page (using page slugs defined in the site tree).
2. **Route enhancement** — the configured route enhancer parses the remainder of the URL
   and populates plugin arguments.

Only after both stages does Extbase dispatch the request to a controller action.
This means routing configuration always lives at the *site* level, not inside the
extension itself.

..  _extbase-routing-namespace:

Plugin argument namespaces
==========================

Every Extbase plugin has an auto-generated namespace derived from its extension
and plugin keys. For an extension :yaml:`my_extension` and plugin :yaml:`Conferences`:

..  code-block:: none

    tx_myextension_conferences

All plugin arguments appear under this namespace in the raw URL:

..  code-block:: none

    ?tx_myextension_conferences[action]=show&tx_myextension_conferences[controller]=Conference&tx_myextension_conferences[conference]=42

The :ref:`Extbase plugin enhancer <extbase-routing-enhancer>` uses exactly this
namespace to match and generate URLs. You never need to write the namespace by
hand — configure :yaml:`extension` and :yaml:`plugin` keys and the enhancer derives it.


Where routing is configured
===========================

Place routing configuration in a :ref:`site set <site-sets>` file inside your
extension:

..  code-block:: none

    EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

TYPO3 picks this file up automatically when the set is active — no additional
declaration is needed. The file must use :yaml:`routeEnhancers` as the root key:

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

    routeEnhancers:
        MyExtensionPlugin:
            # … enhancer configuration

If the project does not use site sets, routing configuration lives directly in
the site's :file:`config/sites/<site-identifier>/config.yaml`, or is pulled in
via a YAML import:

..  code-block:: yaml
    :caption: config/sites/my-site/config.yaml

    imports:
        - { resource: "EXT:my_extension/Configuration/Routes/Default.yaml" }

..  seealso::

    *   :ref:`site-sets` — site sets and what they can ship.

    *   `Using imports in YAML files <https://docs.typo3.org/permalink/t3coreapi:routing-tips>`_ —
        how to split routing configuration across files without site sets.


Prerequisites
=============

Before routing can work:

*   The plugin must be :ref:`registered and placed on a page <extbase-registration-frontend-plugin>`.
*   The page must have a slug set (visible in page properties).
*   The site must have a site configuration (:file:`config/sites/`).

A detail page URL like ``/conferences/typo3camp-2025`` requires both a ``/conferences``
page slug *and* a plugin instance placed on that page. If either is missing, TYPO3
cannot resolve the route.

..  toctree::
    :titlesonly:
    :hidden:

    Enhancer
    Routes
    Aspects
    UriBuilder
    Examples
