:navigation-title: Route enhancer

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Route enhancer
..  _extbase-routing-enhancer:

=======================================
The Extbase plugin route enhancer
=================================

TYPO3 provides three built-in route enhancer types. For Extbase plugins, always
use :yaml:`type: Extbase`. It differs from the generic :yaml:`Plugin` enhancer in one
important way: it generates one route variant *per controller/action combination*
and handles the plugin argument namespace automatically.

..  seealso::

    *   `Routing Enhancers <https://docs.typo3.org/permalink/t3coreapi:routing-advanced-routing-configuration-enhancers>`_ —
        overview of all enhancer types and how enhancers and aspects work together.

    *   `Extbase plugin enhancer reference <https://docs.typo3.org/permalink/t3coreapi:routing-extbase-plugin-enhancer>`_ —
        the full reference entry in the Core routing chapter.


..  _extbase-routing-enhancer-namespace:

How the plugin namespace is derived
===================================

Every Extbase plugin has an auto-generated namespace used to prefix all its
URL parameters. The namespace is derived from the :yaml:`extension` and :yaml:`plugin`
keys in the enhancer configuration:

..  code-block:: none

    tx_<lowercased_extension>_<lowercased_plugin>

For :yaml:`extension: MyExtension` and :yaml:`plugin: Conferences` the namespace is
:yaml:`tx_myextension_conferences`. You never write this by hand — the enhancer
derives it from those two keys.

Alternatively, set :yaml:`namespace` directly if you need an exact string (for
example, when the auto-derived name would be wrong for a multi-word extension
key):

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

    routeEnhancers:
        ConferencesPlugin:
            type: Extbase
            namespace: tx_myextension_conferences
            # … routes …

..  seealso::

    `Extbase plugin enhancer with explicit namespace <https://docs.typo3.org/permalink/t3coreapi:routing-extbase-plugin-enhancer>`_ —
    the :yaml:`namespace` property as an alternative to :yaml:`extension` + :yaml:`plugin`.


..  _extbase-routing-enhancer-config:

Enhancer configuration
======================

A minimal working enhancer for a plugin with a list and a detail action:

..  literalinclude:: _snippets/_enhancer-minimal.yaml
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/route-enhancers.yaml

The key properties:

``type: Extbase``
    Selects the Extbase plugin enhancer.

``limitToPages``
    Restricts the enhancer to specific pages. Always set this — without it TYPO3
    evaluates the enhancer for every page, which slows down route generation
    across the whole site.

    Each entry is :abbr:`OR (logical or)`-combined. Integer values match against
    the page UID. String values are Symfony ExpressionLanguage expressions with
    access to ``page`` (the full page record array), ``site``, and
    ``siteLanguage``.

    ..  versionadded:: 14.2

        Expression language support in ``limitToPages`` was added.

    Plain page UIDs — sufficient for small, stable site trees:

    ..  code-block:: yaml

        limitToPages:
            - 42
            - 99

    Match by backend layout — useful when layout reliably identifies plugin pages:

    ..  code-block:: yaml

        limitToPages:
            - 'page["backend_layout"] == "pagets__conferences"'

    A robust, UID-free approach is to register a custom value for the
    :guilabel:`Contains Plugin` page property (the ``module`` field) in
    :file:`EXT:my_extension/Configuration/TCA/Overrides/pages.php`:

    ..  code-block:: php
        :caption: EXT:my_extension/Configuration/TCA/Overrides/pages.php

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
            'pages',
            'module',
            [
                'label' => 'Conference plugin',
                'value' => 'conferences',
            ],
        );

    Editors set this field on the plugin page in the backend, then the enhancer
    targets those pages without any hardcoded UIDs:

    ..  code-block:: yaml

        limitToPages:
            - 'page["module"] == "conferences"'

    All approaches can be mixed in one array — entries are OR-combined. Use
    ``&&`` inside a single string for AND logic.

``extension``
    The extension name in UpperCamelCase, without vendor prefix and without
    underscores (for example ``MyExtension``, not ``my_extension``).

``plugin``
    The plugin name as registered in :php:`\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin()`
    (for example ``Conferences``).

:yaml:`defaultController`
    The controller/action pair used when no route variant matches. Written as
    :yaml:`ControllerName::actionName` (no :php:`Action` suffix, no namespace).
    When a URL is generated for this controller/action combination and no
    :yaml:`routePath` has placeholders, the route still resolves cleanly.

:yaml:`routes`
    One entry per controller/action combination that should produce a readable
    URL. See :ref:`extbase-routing-routes` for the full route syntax.

:yaml:`aspects`
    Maps placeholder names to mappers that translate between internal values
    (UIDs) and URL segments (slugs). See :ref:`extbase-routing-aspects`.


..  _extbase-routing-enhancer-variants:

How route variants are matched
==============================

When TYPO3 receives a request, the enhancer tries each :yaml:`routes` entry in
order. The first variant whose :yaml:`routePath` pattern and :yaml:`_controller`
match the incoming URL wins. When generating a URL, TYPO3 picks the first
variant that satisfies all required placeholders.

Order matters: put more specific routes before more general ones. A route
:yaml:`/{conference_slug}` would swallow everything if listed before
:yaml:`/page/{page}` — the paginated list would never match.

If no variant matches during generation, TYPO3 falls back to a plain query
string URL with the raw namespace parameters and a :yaml:`cHash`.


..  _extbase-routing-enhancer-chash:

The cHash parameter
===================

When a URL contains dynamic parameters that are not fully constrained,
TYPO3 appends a ``cHash`` signature to prevent cache poisoning. Strict
:yaml:`requirements` and :ref:`aspects <extbase-routing-aspects>` that define
a fixed set of valid values eliminate the need for ``cHash``.

A :php-short:`\TYPO3\CMS\Core\Routing\Aspect\PersistedAliasMapper` aspect on
a slug field removes ``cHash`` for that placeholder because the mapper acts as
a static value source. A ``\d+`` requirement alone does not — only a
:php-short:`\TYPO3\CMS\Core\Routing\Aspect\StaticRangeMapper` does.

..  seealso::

    `cHash and routing <https://docs.typo3.org/permalink/t3coreapi:routing-advanced-routing-configuration-enhancers>`_ —
    background on when and why ``cHash`` is added.

The next step is defining the individual routes inside the enhancer — see
:ref:`extbase-routing-routes`.
