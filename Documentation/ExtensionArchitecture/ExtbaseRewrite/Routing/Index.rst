:navigation-title: Routing

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Routing
..  _extbase-routing:

===========================
Routing for Extbase plugins
===========================

Every Extbase plugin action produces URLs with a namespaced query string when
no routing configuration exists:

..  code-block:: none

    https://example.org/conferences?tx_myextension_conferences[action]=show&tx_myextension_conferences[controller]=Conference&tx_myextension_conferences[conference]=42&cHash=…

Routing configuration transforms these into readable, :abbr:`SEO (Search Engine Optimisation)`-friendly URLs:

..  code-block:: none

    https://example.org/conferences/typo3camp-2025

TYPO3's routing system is built on top of Symfony routing components. The
Extbase plugin enhancer is a specialised layer on top — it handles the
controller/action namespace automatically. Moving plugin arguments out of the
query string and into the path also simplifies
:ref:`cHash <extbase-routing-enhancer-chash>` handling considerably — a fully
routed URL needs no ``cHash`` at all. Understanding the general TYPO3 routing
concepts first makes Extbase routing much easier to follow.

..  seealso::

    *   `Routing — readable, SEO-friendly URLs <https://docs.typo3.org/permalink/t3coreapi:routing>`_ —
        overview of TYPO3 routing, terminology (slug, enhancer, aspect), and page-based routing.

    *   `Route Enhancements and Aspects <https://docs.typo3.org/permalink/t3coreapi:routing-advanced-routing-configuration>`_ —
        the full reference for all enhancer types and aspects available in TYPO3 Core.


..  _extbase-routing-how-it-works:

How TYPO3 routing works with Extbase
====================================

TYPO3 resolves a request in two stages:

1. **Page routing** — maps the URL path to a page (using page slugs defined in the site tree).
2. **Route enhancement** — a configured route enhancer parses the remainder of the URL
   and populates plugin arguments. A site can define many enhancers (one per plugin,
   each under its own key in :yaml:`routeEnhancers`); TYPO3 tries each until one matches.

Only after both stages does Extbase dispatch the request to a controller action.
Route enhancers are resolved as part of the *site* configuration. The configuration
itself can still ship inside your extension — a :ref:`site set <site-sets>` is the
recommended way to provide it — but it only takes effect once the site activates that
set. The :ref:`section below <extbase-routing-where-configured>` covers placement.

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


..  _extbase-routing-where-configured:

Where routing is configured
===========================

Place routing configuration in a :ref:`site set <site-sets>` file inside your
extension:

..  code-block:: none

    EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

The filename is fixed: a site set is scanned for a file named exactly
:file:`route-enhancers.yaml` at the set root, and TYPO3 picks it up automatically
when the set is active — no additional declaration is needed. The file must use
:yaml:`routeEnhancers` as its single root key (TYPO3 raises an error on any other
top-level key):

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

    *   `Site sets <https://docs.typo3.org/permalink/t3coreapi:site-sets>`_ —
        site sets and what they can ship.

    *   `Using imports in YAML files <https://docs.typo3.org/permalink/t3coreapi:routing-tips>`_ —
        how to split routing configuration across files without site sets.


..  _extbase-routing-prerequisites:

Prerequisites
=============

Before routing can work:

*   The plugin must be :ref:`registered and placed on a page <extbase-registration-frontend-plugin>`.
*   A :ref:`slug <t3tca:columns-slug>` must be set for the page (visible in the
    page properties).
*   The site must have a site configuration (:file:`config/sites/`).

A detail page URL like :samp:`/conferences/typo3camp-2025` requires both a
:samp:`/conferences` page slug *and* a plugin instance placed on that page. If either is missing, TYPO3
cannot resolve the route.

..  toctree::
    :titlesonly:
    :hidden:

    Enhancer
    Routes
    Aspects
    UriBuilder
    Examples

