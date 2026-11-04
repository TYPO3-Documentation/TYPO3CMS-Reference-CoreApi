:navigation-title: Route enhancer

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Route enhancer
..  _extbase-routing-enhancer:

=================================
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

..  literalinclude:: _extbaseEnhancerNamespace.yaml
    :caption: EXT:my_extension/Configuration/Sets/Main/route-enhancers.yaml (excerpt)

The key directly under :yaml:`routeEnhancers` — :yaml:`ConferencesPlugin` here — is
an arbitrary identifier you choose. It only has to be unique across all enhancers on
the site; it is not tied to the extension or plugin name. Pick something descriptive.

..  seealso::

    `Extbase plugin enhancer with explicit namespace <https://docs.typo3.org/permalink/t3coreapi:routing-extbase-plugin-enhancer>`_ —
    the :yaml:`namespace` property as an alternative to :yaml:`extension` + :yaml:`plugin`.


..  _extbase-routing-enhancer-config:

Enhancer configuration
======================

A complete enhancer for a plugin with a list and a detail action, showing the
recommended baseline. Only :yaml:`type`, :yaml:`extension`, :yaml:`plugin` and
:yaml:`routes` are strictly required; :yaml:`limitToPages` is included here
because you should always scope an enhancer to its pages (see below), and
:yaml:`defaultController` is omitted as it is optional:

..  literalinclude:: _snippets/_enhancer-minimal.yaml
    :caption: EXT:my_extension/Configuration/Sets/Main/route-enhancers.yaml

The key properties:

:yaml:`type: Extbase`
    Selects the Extbase plugin enhancer.

:yaml:`limitToPages`
    Restricts the enhancer to specific pages. Always set this — without it TYPO3
    evaluates the enhancer for every page, which slows down route generation
    across the whole site.

    Each entry is :abbr:`OR (logical or)`-combined. Integer values match against
    the page UID. String values are
    :ref:`Symfony expression language <t3coreapi:symfony-expression-language>`
    expressions with access to :yaml:`page` (the full page record array),
    :yaml:`site`, and :yaml:`siteLanguage`.

    ..  versionadded:: 14.2

        Expression language support in :yaml:`limitToPages` was added.

    Match by backend layout — useful when layout reliably identifies plugin pages:

    ..  code-block:: yaml

        limitToPages:
          - 'page["backend_layout"] == "pagets__conferences"'

    A robust, UID-free approach is to register a custom value for the
    **Contains Plugin** page property (the :sql:`module` field) in
    :file:`EXT:my_extension/Configuration/TCA/Overrides/pages.php`:

    ..  literalinclude:: _snippets/_pages.php
        :caption: EXT:my_extension/Configuration/TCA/Overrides/pages.php

    Editors set this field on the plugin page in the backend, then the enhancer
    targets those pages without any hardcoded UIDs:

    ..  code-block:: yaml

        limitToPages:
          - 'page["module"] == "conferences"'

    Plain page UIDs:

    ..  code-block:: yaml

        limitToPages:
          - 42
          - 99

    All approaches can be mixed in one array — entries are OR-combined. Use
    `&&` inside a single string for AND logic.

:yaml:`extension`
    The extension name in UpperCamelCase, without vendor prefix and without
    underscores (for example :yaml:`MyExtension`, not :yaml:`my_extension`).

:yaml:`plugin`
    The plugin name as registered in :php:`\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin()`
    (for example :yaml:`Conferences`).

:yaml:`defaultController` (optional)
    The controller/action pair to assume when an incoming URL carries no explicit
    controller or action. Written as :yaml:`ControllerName::actionName` (no
    :php:`Action` suffix, no namespace). It is only a fallback: generated URLs
    (via :ref:`uriFor() <extbase-routing-uri-builder>`) always supply the
    controller and action, so a minimal enhancer can omit this key.

:yaml:`routes`
    One entry per controller/action combination that should produce a readable
    URL. For example, a single route for the detail action:

    ..  code-block:: yaml

        routes:
          - routePath: '/{conference_slug}'
            _controller: 'Conference::show'

    See :ref:`Defining routes for Extbase plugins <extbase-routing-routes>` for
    the full route syntax.

:yaml:`aspects`
    Maps placeholder names to mappers that translate between internal values
    (UIDs) and URL segments (slugs). For example, mapping the
    :yaml:`conference_slug` placeholder above to a database slug field:

    ..  code-block:: yaml
        :caption: EXT:my_extension/Configuration/Sets/Main/route-enhancers.yaml

        aspects:
          conference_slug:
            type: PersistedAliasMapper
            tableName: tx_myextension_domain_model_conference
            routeFieldName: slug

    See :ref:`Routing aspects <extbase-routing-aspects>`.


..  _extbase-routing-enhancer-variants:

How route variants are matched
==============================

Incoming URLs and generated URLs use the routes differently.

When TYPO3 receives a request, it tests the :yaml:`routes` entries in the
order of their configuration. A route is skipped if the URL does not fit its
:yaml:`routePath` and :yaml:`requirements`, or if an
:ref:`aspect <extbase-routing-aspects>` of the route cannot resolve the value
taken from the URL. The first route that is not skipped wins. The
:yaml:`_controller` of a route is not compared with anything here, it is the
result of the match. See
:ref:`Route order and specificity <extbase-routing-routes-order>`.

When generating a URL, TYPO3 only considers the routes whose
:yaml:`_controller` is the controller and action of the link, and whose
placeholders are all supplied by the link or filled by :yaml:`defaults`. It
then sorts these routes, regardless of their configuration order:

#.  Routes with placeholders come before routes without placeholders, such as
    :yaml:`/`.
#.  Routes for which the link supplies every placeholder come before routes
    that need :yaml:`defaults`. Among them, the route with more placeholders
    comes first.
#.  Routes that need fewer :yaml:`defaults` come before routes that need more.

TYPO3 uses the first route in this order that works. A route is skipped if an
aspect cannot map a value, or if a mapped value does not fit the
:yaml:`requirements`.

If no variant matches during generation, TYPO3 falls back to a plain query
string URL with the raw namespace parameters and a :yaml:`cHash`.


..  _extbase-routing-enhancer-chash:

The `cHash` parameter
=====================

When a URL contains dynamic parameters that are not fully constrained,
TYPO3 appends a `cHash` signature. This prevents arbitrary URIs from being
cached under the same content — both stopping the cache from growing without
bound and guarding against
`cache poisoning <https://en.wikipedia.org/wiki/Cache_poisoning>`_, where an
attacker fills the cache with junk variants of a page.

TYPO3 leaves out `cHash` only when *every* argument of the URL is static. If
even one placeholder is dynamic, TYPO3 still adds `cHash` to the whole URL.
A placeholder is static in one of two cases:

*   It has an :ref:`aspect <extbase-routing-aspects>` that limits it to a known
    set of values. All mappers of TYPO3 Core do so:
    :php-short:`\TYPO3\CMS\Core\Routing\Aspect\StaticRangeMapper` and
    :php-short:`\TYPO3\CMS\Core\Routing\Aspect\StaticValueMapper` with a fixed
    list, :php-short:`\TYPO3\CMS\Core\Routing\Aspect\PersistedAliasMapper` and
    :php-short:`\TYPO3\CMS\Core\Routing\Aspect\PersistedPatternMapper` with the
    values stored in the database.
*   It has no aspect, is declared in :yaml:`static`, and has a
    :yaml:`requirements` entry. TYPO3 ignores a :yaml:`static` declaration
    without a requirement, and also one for a placeholder that has an aspect.

A requirement alone does not make a placeholder static, however strict it is.
A placeholder with :yaml:`'\d+'` still accepts an unbounded number of values.

..  code-block:: yaml
    :caption: EXT:my_extension/Configuration/Sets/Main/route-enhancers.yaml (excerpt)

    routes:
      - routePath: '/confirm/{token}'
        _controller: 'Registration::confirm'
    static:
      token: true
    requirements:
      token: '[a-f0-9]{40}'

Keep such a requirement as narrow as possible. Every value it accepts can be
cached as a page of its own.

..  seealso::

    *   `cHash and routing <https://docs.typo3.org/permalink/t3coreapi:routing-advanced-routing-configuration-enhancers>`_ —
        background on when and why `cHash` is added.

    *   `Static route variables <https://docs.typo3.org/permalink/t3coreapi:routing-static-variables>`_ —
        the :yaml:`static` option in the Core routing reference.

The next step is defining the individual routes inside the enhancer — see
:ref:`Defining routes for Extbase plugins <extbase-routing-routes>`.
