:navigation-title: Reference

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Configuration reference
..  _extbase-configuration-reference:

===============================
Extbase configuration reference
===============================

Most of an Extbase plugin's configuration is written in TypoScript. Some of
these settings are read by the framework itself — they tell Extbase where to
find templates, which pages to read records from, and how to behave when an
action cannot be resolved. Others are your own, application-specific settings
that you read inside controllers and Fluid templates. Two further blocks on this
page are *not* TypoScript: values an editor feeds in through FlexForm, and a
handful of installation-wide feature toggles.

This page is the working reference for each configuration block an Extbase
extension uses in practice. For the exhaustive list of every TypoScript property
with its data type and default value, see the
:ref:`plugin reference in the TypoScript Reference <t3tsref:setup-plugin-extbase>`.
For the bigger picture of which configuration surface owns what, see
:ref:`extbase-configuration`.

..  contents:: On this page
    :local:
    :depth: 1

..  _extbase-configuration-typoscript-scopes:

Where Extbase TypoScript lives
==============================

When you register a plugin with
:php:`\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin()`, Extbase
creates a configuration object in the TypoScript tree. The position depends on
the extension key and the plugin name.

Settings for **all plugins** of an extension go below
:typoscript:`plugin.tx_<extensionkey>` — the extension key written without
underscores. For an extension with the key :file:`EXT:my_extension` this is
:typoscript:`plugin.tx_myextension`.

Settings for **one specific plugin** go below
:typoscript:`plugin.tx_<extensionkey>_<pluginname>`, for example
:typoscript:`plugin.tx_myextension_conferencelist`. Values set here override the
extension-wide values from :typoscript:`plugin.tx_myextension`.

:ref:`Backend modules <backend-modules-api>` use the same pattern below
:typoscript:`module.tx_<extensionkey>` and
:typoscript:`module.tx_<extensionkey>_<modulename>`.

A few framework settings can also be set globally for every Extbase plugin and
module at once below :typoscript:`config.tx_extbase`. Use this scope sparingly —
plugin-specific configuration is almost always clearer. See
:ref:`extbase-configuration-typoscript-global-scope`.

The merge order, from lowest to highest precedence, is:

#.  :typoscript:`config.tx_extbase` (global)
#.  :typoscript:`plugin.tx_myextension` (extension-wide)
#.  :typoscript:`plugin.tx_myextension_conferencelist` (plugin-specific)
#.  :ref:`FlexForm <t3coreapi:flexforms>` values set by the editor on the content
    element

FlexForm values therefore win over TypoScript, field by field. A field an editor
leaves blank can still override the matching TypoScript default with its empty
value; :typoscript:`ignoreFlexFormSettingsIfEmpty` (see
:ref:`extbase-configuration-typoscript-other`) keeps the TypoScript value in that
case.

..  tip::

    All TypoScript examples on this page use the
    :ref:`site set <t3coreapi:site-sets>` file
    :file:`EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript`,
    which is loaded automatically when the set is active. Projects that do not
    use site sets can place the same TypoScript in an included
    :file:`setup.typoscript` instead.

..  _extbase-configuration-typoscript-global-scope:

The global scope: :typoscript:`config.tx_extbase`
=================================================

The :typoscript:`config.tx_extbase` block is the one scope that is **not** bound
to a single extension. Everything below :typoscript:`plugin.tx_myextension` or
:typoscript:`plugin.tx_myextension_pluginname` configures one extension or one
plugin; values placed below :typoscript:`config.tx_extbase` apply to **every
Extbase plugin and module in the frontend**, no matter which extension ships
them. It is the lowest-precedence layer in the merge order above, so any
extension- or plugin-level value overrides it.

Only the **framework** sub-keys are meaningful here — the ones Extbase itself
reads to steer control flow, namely :typoscript:`mvc` (error handling) and
:typoscript:`persistence` (class-to-table mapping). The :typoscript:`settings`
and :typoscript:`view` blocks are inherently application-specific: a global
:typoscript:`settings` value would leak into every third-party plugin, and
template paths only make sense per extension. Do not put either there.

..  warning::

    Use this scope sparingly. A value set here changes the behaviour of plugins
    you did not write — every installed
    Extbase extension — and it does so from a global block their maintainers have
    no reason to inspect. Plugin-specific configuration is self-documenting;
    global configuration acts at a distance. Reach for
    :typoscript:`config.tx_extbase` only for a deliberate **installation-wide
    policy**, and prefer per-plugin configuration in every other case. A global
    value placed here by mistake is a documented pitfall — see
    :ref:`extbase-appendix-pitfalls-global-config`.

The legitimate case is a policy that must hold even for plugins you do not
control. The clearest example is MVC error handling: "on this site, *any*
Extbase action that cannot be resolved returns a 404 rather than silently
falling back to a default action". Setting that once globally is more robust than
hoping every installed extension configured it.

..  literalinclude:: _snippets/_globalscope.typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/MySitepackage/setup.typoscript

A single plugin can still opt out by overriding the same key under its own
:typoscript:`plugin.tx_<extensionkey>_<pluginname>.mvc`, because plugin scope
wins over the global scope.

..  _extbase-configuration-typoscript-settings:

Custom settings: the :typoscript:`settings` block
=================================================

The :typoscript:`settings` block holds your own configuration values —
everything from "how many items per page" to default values for business logic. Extbase makes
these available in two places automatically:

*   In controllers as the array :php:`$this->settings`
*   In every Fluid template as the variable :html:`{settings}`

..  literalinclude:: _snippets/_settings.typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

The nested value above is read in a controller as
:php:`$this->settings['itemsPerPage']` and
:php:`$this->settings['archive']['showInSidebar']`, and in Fluid as
:html:`{settings.itemsPerPage}` and :html:`{settings.archive.showInSidebar}`.

Settings defined for a specific plugin override the extension-wide ones of the
same name, and an editor can override individual settings per content element
through the plugin's FlexForm.

..  _extbase-configuration-typoscript-settings-contentblocks:

Feeding settings from a Content Block FlexForm
----------------------------------------------

A content element built with Content Blocks that renders an Extbase plugin can
feed values straight into :php:`$this->settings` — without you writing a FlexForm
data structure by hand. This is a little-known but very practical trick, and it
becomes more relevant as Content Blocks technology moves into the Core.

The mechanism: when the content block reuses the :sql:`pi_flexform` field and
defines a FlexForm field whose identifier is :yaml:`settings.<name>`, that value
is merged into :php:`$this->settings['<name>']` exactly like a TypoScript-defined
setting. The same applies to the reusable :sql:`pages` and :sql:`recursive`
fields, which feed :typoscript:`persistence.storagePid` and
:typoscript:`persistence.recursive`.

..  literalinclude:: _snippets/_contentblock.yaml
    :caption: EXT:my_extension/ContentBlocks/ContentElements/conference-list/config.yaml

Two pieces wire this up:

#.  The content block renders through an
    :ref:`EXTBASEPLUGIN <t3tsref:cobj-extbaseplugin>` (Content Blocks provides
    the rendering definition; you only set the :typoscript:`pluginName`).
#.  Because the element renders as an Extbase plugin **and** carries a
    :sql:`pi_flexform` value, Extbase's normal FlexForm-to-settings merge applies.

The editor now sees an "Items per page" field on the content element, and the
controller reads it as :php:`$this->settings['itemsPerPage']` — no custom
FlexForm XML required.

..  seealso::

    `Create Extbase plugins (Content Blocks documentation) <https://docs.typo3.org/permalink/friendsoftypo3-content-blocks:create-extbase-plugin>`_
    — how to register an Extbase plugin as a content block.

..  _extbase-configuration-typoscript-persistence:

Persistence: storage pages and new-record locations
===================================================

The :typoscript:`persistence` block controls where Extbase reads records from
and where it writes new ones.

..  literalinclude:: _snippets/_persistence.typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

:typoscript:`storagePid`
    A comma-separated list of page IDs. Repository read queries return records
    **only** from these pages.

:typoscript:`recursive`
    The number of subpage levels below each :typoscript:`storagePid` that are
    also searched. The default `0` means only the listed pages themselves.

:typoscript:`classes.<FQCN>.newRecordStoragePid`
    The page ID where new records of a given domain class are stored when the
    repository persists them. Without it, new records are written to the first
    configured :typoscript:`storagePid`. The key is the fully-qualified class
    name of the :ref:`domain model <extbase-domain-model>`. Because the key is
    per class, different models can be stored in different folders — for example
    new :php:`Conference` records on one page and new :php:`Speaker` records on
    another, as shown above.

:typoscript:`enableAutomaticCacheClearing`
    Enabled by default. When Extbase persists a change, it clears the page cache
    for the affected records automatically. See
    :ref:`extbase-caching-overview` for when and why you might disable this.

..  seealso::

    *   :ref:`extbase-concepts-persistence-storagepid` — the full
        :typoscript:`storagePid` resolution rules, and how to disable
        storage-page filtering entirely.

    *   :ref:`extbase-appendix-pitfalls-storagepid` — why a repository query
        returns nothing when the storage page is misconfigured.

..  _extbase-configuration-typoscript-view:

View: template, partial and layout paths
========================================

The :typoscript:`view` block tells Extbase where to look for Fluid templates,
partials and layouts. Each is an **array** of paths so that a sitepackage can
override an extension's templates without touching the extension itself.

..  literalinclude:: _snippets/_viewpaths.typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/MySitepackage/setup.typoscript

..  _extbase-configuration-typoscript-view-defaults:

The default paths and how overriding works
------------------------------------------

At render time,
:php-short:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController` adds the
extension's own resource directories to the configured paths as defaults:

*   :file:`EXT:my_extension/Resources/Private/Templates/`
*   :file:`EXT:my_extension/Resources/Private/Partials/`
*   :file:`EXT:my_extension/Resources/Private/Layouts/`

The default is added at the **front** of the array, where it acts as the
lowest-priority entry. Fluid resolves paths by **highest numeric key first** and
uses the first matching file it finds. The three cases below show what
Extbase ends up looking at for templates. Those implicit additions are not shown in the
:guilabel:`TypoScript -> Active TypoScript` Backend Module.

**Case 1 — no** :typoscript:`view.templateRootPaths` **configured.** The default
is the only path:

..  code-block:: text
    :caption: Paths Fluid searches (highest key first)

    EXT:my_extension/Resources/Private/Templates/

**Case 2 — an override added under a high key.** This is the usual sitepackage
override:

..  code-block:: typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/MySitepackage/setup.typoscript

    plugin.tx_myextension.view.templateRootPaths.10 = EXT:my_sitepackage/Resources/Private/Extensions/MyExtension/Templates/

..  code-block:: text
    :caption: Paths Fluid searches (highest key first)

    10  EXT:my_sitepackage/.../Templates/               <- checked first
        EXT:my_extension/Resources/Private/Templates/   (prepended default)

Fluid uses your sitepackage template if the file exists there, and otherwise
falls back to the extension's own template. Your override does not have to be
complete — only the templates you actually want to change need to exist.

**Case 3 — the default moved to a different priority.** List the default path
explicitly under a key of your choosing. An explicitly listed default keeps the
position you give it instead of being prepended:

..  code-block:: typoscript
    :caption: EXT:my_sitepackage/Configuration/Sets/MySitepackage/setup.typoscript

    plugin.tx_myextension.view.templateRootPaths {
        10 = EXT:my_extension/Resources/Private/Templates/
        20 = EXT:my_sitepackage/Resources/Private/Extensions/MyExtension/Templates/
    }

..  code-block:: text
    :caption: Paths Fluid searches (highest key first)

    20  EXT:my_sitepackage/.../Templates/        <- checked first
    10  EXT:my_extension/Resources/Private/Templates/

The same prepend-and-override behaviour applies to
:typoscript:`partialRootPaths` and :typoscript:`layoutRootPaths`.

..  _extbase-configuration-typoscript-view-pluginnamespace:

Sharing an argument namespace between plugins
---------------------------------------------

By default every plugin has its own argument namespace: the
:samp:`tx_<extensionkey>_<pluginname>[...]` prefix on request arguments and form
fields, for example :samp:`tx_myextension_conferencelist[conference]=5`. This
isolation is deliberate — two plugins on the same page do not collide.

:typoscript:`view.pluginNamespace` overrides that prefix. It has two distinct
uses:

#.  **Shorten the prefix** for tidier URLs:

    ..  code-block:: typoscript
        :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

        plugin.tx_myextension_conferencelist.view.pluginNamespace = conf

    Arguments are now :samp:`conf[conference]=5` instead of the long default.

#.  **Deliberately share a namespace between two plugins** so that one plugin can
    read the other's arguments. Point both plugins at the **same**
    :typoscript:`pluginNamespace`:

    ..  code-block:: typoscript
        :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

        plugin.tx_myextension_conferencelist.view.pluginNamespace = conf
        plugin.tx_myextension_conferencefilter.view.pluginNamespace = conf

    A filter plugin and a list plugin sharing the :samp:`conf` namespace can now
    act on the same arguments — the filter's form submits values that the list
    plugin reads, without the list plugin having to know the filter's plugin
    name. This is the supported way to make separate plugins cooperate; do not
    try to read another plugin's default namespace by guessing its prefix.

    ..  warning::

        Only share a namespace on purpose. If two unrelated plugins end up with
        the same namespace by accident, their arguments overwrite each other.

    See :ref:`extbase-routing-uri-builder` for how the namespace affects
    generated URIs.

..  _extbase-configuration-typoscript-mvc:

MVC error handling: the :typoscript:`mvc` block
===============================================

The :typoscript:`mvc` block controls what Extbase does when a request cannot be
dispatched to a valid action. There are two separate failure stages, and the
settings fall into two corresponding pairs. All accept a boolean (`0` or `1`)
and can be set per plugin or globally on :typoscript:`config.tx_extbase`.

..  rubric:: Stage 1 — the requested action does not exist

These two apply when the request asks for an action that is **not registered**
for the plugin at all (a typo in the URL, a removed action, a manipulated
request). They are mutually exclusive; pick one:

:typoscript:`callDefaultActionIfActionCantBeResolved`
    Silently fall back to the plugin's first registered action instead of
    failing. The visitor sees the default action's output. Use this when an
    unknown action should degrade gracefully to a sensible default view.

:typoscript:`throwPageNotFoundExceptionIfActionCantBeResolved`
    Show a "page not found" (HTTP 404) response instead. Use this when an unknown
    action should look like a missing page to visitors and search engines rather
    than silently showing something else.

..  rubric:: Stage 2 — the action exists, but argument mapping fails

The action is valid, but Extbase cannot build its arguments. This happens during
**argument mapping**, after the action has been resolved, and is handled by
:php:`ActionController::handleArgumentMappingExceptions()`. The two triggers are
different:

:typoscript:`showPageNotFoundIfTargetNotFoundException`
    The argument references a domain object that **no longer exists** — for
    example :samp:`?tx_myextension_conferencelist[conference]=999` where
    conference 999 was deleted. Without this setting Extbase throws a
    :php:`\TYPO3\CMS\Extbase\Property\Exception\TargetNotFoundException`; with it,
    the 404 page is shown. This is the typical "linked record was deleted" case.

:typoscript:`showPageNotFoundIfRequiredArgumentIsMissingException`
    A **required** argument is absent entirely — the URL omits an argument the
    action declares as mandatory. Without this setting Extbase throws a
    :php:`\TYPO3\CMS\Extbase\Mvc\Exception\RequiredArgumentMissingException`; with
    it, the 404 page is shown.

For behaviour beyond "show the 404 page" — logging, a redirect, a custom error
view — override :php:`handleArgumentMappingExceptions()` in your controller. The
default implementation lives in
:php-short:`\TYPO3\CMS\Extbase\Mvc\Controller\ActionController`; copy its
signature and inspect the passed :php:`\Exception` to decide what to do.

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

    plugin.tx_myextension {
        mvc {
            throwPageNotFoundExceptionIfActionCantBeResolved = 1
            showPageNotFoundIfTargetNotFoundException = 1
            showPageNotFoundIfRequiredArgumentIsMissingException = 1
        }
    }

..  _extbase-configuration-typoscript-other:

Output format, language overrides and FlexForm handling
=======================================================

..  confval:: format
    :name: extbase-configuration-typoscript-format
    :type: string
    :Default: html

    Sets the default template file format, which determines the template file
    extension Extbase looks for. Prefer a dedicated action per output format
    over switching :typoscript:`format` globally — separate actions keep
    responsibility for each format in the controller where it is easy to find.

:typoscript:`_LOCAL_LANG`
    Overrides individual translation labels of a plugin without editing its XLF
    files. The key is the language key (`default` or an ISO 639-1 code) followed
    by the translation-unit ID:

    ..  code-block:: typoscript
        :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

        plugin.tx_myextension_conferencelist._LOCAL_LANG.default.list.heading = Upcoming conferences
        plugin.tx_myextension_conferencelist._LOCAL_LANG.de.list.heading = Kommende Konferenzen

:typoscript:`ignoreFlexFormSettingsIfEmpty`
    A comma-separated list of FlexForm field names whose empty values should
    **not** override the TypoScript settings of the same name. Because FlexForm
    values take precedence over TypoScript, a field an editor leaves blank would
    otherwise overrule a TypoScript default with its empty value; listing the
    field here keeps the TypoScript value when the field is left blank. The
    PSR-14 :ref:`BeforeFlexFormConfigurationOverrideEvent` allows further
    adjustment of the merged configuration.

..  seealso::

    `A blank FlexForm field silently overrides the TypoScript default <https://docs.typo3.org/permalink/extbase-appendix-pitfalls-flexform-empty-overrides>`_
    — the pitfall this setting prevents, with a worked example.

..  _extbase-configuration-feature-toggles:

Extbase feature toggles (not TypoScript)
========================================

Two Extbase behaviours are controlled by global
:ref:`feature toggles <feature-toggles>`, not by TypoScript. They live in
:php:`$GLOBALS['TYPO3_CONF_VARS']['SYS']['features']` (configured through
:file:`settings.php` or the :guilabel:`Settings > Feature Toggles` backend
module) and apply to the whole installation rather than to a single plugin.

:php:`extbase.consistentDateTimeHandling`
    Enabled by default. Aligns Extbase's :php:`\DateTime` mapping with FormEngine
    and DataHandler, so timezones and integer-based time fields behave
    consistently across the backend and Extbase. See
    :ref:`extbase-model-datetime-consistency`.

:php:`extbase.enableHistoryTracking`
    Disabled by default (added in TYPO3 v14.2). When enabled, changes Extbase
    persists are recorded in :sql:`sys_history` and shown in the backend record
    history, the same way backend edits are. The toggle enables tracking for all
    Extbase tables at once; a single table can opt out via TCA with
    :php:`'ctrl' => ['extbase' => ['enableHistoryTracking' => false]]`. Mind the
    GDPR implications — full data snapshots are stored. See
    :ref:`Feature #107289 <changelog:feature-107289-1734172800>` and
    :ref:`extbase-upgrading-feature-toggle-defaults`.

..  seealso::

    *   `plugin reference (TypoScript Reference) <https://docs.typo3.org/permalink/t3tsref:setup-plugin-extbase>`_
        — the complete list of Extbase plugin properties with data types and defaults.

    *   :ref:`extbase-concepts-persistence-storagepid` — how :typoscript:`storagePid`
        and :typoscript:`recursive` are resolved, and how to bypass storage-page
        filtering.

    *   :ref:`extbase-view-overview` — how the configured template paths are used
        during rendering.

With the plugin configured, you can move on to writing the queries, relations and
templates that turn these settings into a working extension. Start with
:ref:`extbase-persistence-overview` for the data side and
:ref:`extbase-view-overview` for the output.
