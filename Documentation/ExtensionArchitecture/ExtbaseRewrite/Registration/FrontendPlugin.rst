:navigation-title: Frontend plugin

..  include:: /Includes.rst.txt
..  index:: pair: Extbase; Frontend plugin
..  _extbase-registration-frontend-plugin:

======================================
Registering an Extbase frontend plugin
======================================

A frontend plugin is an Extbase extension rendered as a content element on a
TYPO3 page. Registration requires two calls in two different files: one in
:file:`ext_localconf.php` to configure the Extbase dispatcher, and one in
:file:`Configuration/TCA/Overrides/tt_content.php` to make the plugin
selectable in the backend.

..  contents:: On this page
    :local:
    :depth: 1


..  _extbase-registration-frontend-plugin-configure:

Configuring the plugin dispatcher
=================================

:php:`ExtensionUtility::configurePlugin()` registers which controller
actions are allowed and generates the TypoScript to route requests to the Extbase
dispatcher. Call it in :file:`ext_localconf.php`:

..  code-block:: php
    :caption: EXT:my_extension/ext_localconf.php

    use MyVendor\MyExtension\Controller\ConferenceController;
    use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

    defined('TYPO3') or die();

    ExtensionUtility::configurePlugin(
        'MyExtension',
        'ConferenceList',
        [ConferenceController::class => 'list, show, create'],
        [ConferenceController::class => 'create'],
    );

The four arguments are:

1.  **Extension name** — the extension key in UpperCamelCase
    (``my_extension`` → ``MyExtension``).
2.  **Plugin name** — a unique UpperCamelCase identifier for this plugin inside
    the extension. Combined with the extension name, it forms the plugin
    signature used in TypoScript and routing (``myextension_conferencelist``).
    The combined length must not exceed 32 characters. snake_case is also
    accepted and normalised internally, but UpperCamelCase is the convention.
3.  **Allowed controller actions** — an array mapping controller class names to
    a comma-separated list of action names. The first entry and its first action
    are the default. Only actions listed here are available via this plugin.
4.  **Non-cacheable actions** — a subset of the above defining output that must not be
    stored in the page cache. See :ref:`extbase-caching-noncacheable`
    for the implications.

..  versionchanged:: 14.0

    The fifth parameter ``$pluginType`` was removed. All plugins are registered
    as ``CType`` content elements. Omit this argument entirely.


..  _extbase-registration-frontend-plugin-register:

Registering the plugin in the backend
=====================================

:php:`ExtensionUtility::registerPlugin()` adds the plugin to the list of
available content element types in the backend. Call it in
:file:`Configuration/TCA/Overrides/tt_content.php`:

..  code-block:: php
    :caption: EXT:my_extension/Configuration/TCA/Overrides/tt_content.php

    use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

    defined('TYPO3') or die();

    ExtensionUtility::registerPlugin(
        'MyExtension',
        'ConferenceList',
        'my_extension.db:plugin.conferencelist.title',
        'my-extension-conference-list',
        'plugins',
        'my_extension.db:plugin.conferencelist.description',
        'EXT:my_extension/Configuration/FlexForms/ConferenceList.xml',
    );

The arguments are:

1.  **Extension name** — same as in :php:`configurePlugin()`.
2.  **Plugin name** — same as in :php:`configurePlugin()`. The two values must
    match exactly.
3.  **Plugin title** — label shown in the backend content element wizard.
    Use a translatable label reference. The example uses the
    :ref:`translation domain syntax <label-reference-domain>`
    (``extension_key.file:label_key``), which is shorter than the
    legacy ``LLL:EXT:`` path syntax. Both are equivalent and interchangeable.
4.  **Plugin icon** — an icon identifier registered via the Icon
    :abbr:`API (Application Programming Interface)`, or a path prefixed with
    ``EXT:``. Optional. Defaults to the generic plugin icon.
5.  **Group** — groups the plugin in the content element wizard. Common values
    are ``'plugins'`` (generic plugin group) or a custom group name matching
    your extension.
6.  **Description** — optional longer text shown in the content element wizard.
7.  **FlexForm** — path to a FlexForm XML file that adds configurable fields to
    the content element in the backend, for example
    ``'EXT:my_extension/Configuration/FlexForms/ConferenceList.xml'``.
    Optional. Omit if the plugin needs no backend configuration form.

Both calls must use the same extension name and plugin name. A mismatch means
the dispatcher will not find the controller actions registered for that plugin.


..  _extbase-registration-frontend-plugin-configuration-assembly:

How the plugin configuration is assembled
=========================================

When an Extbase frontend plugin handles a request, the framework assembles a
single configuration array from three layers, each able to override the
previous:

1.  :typoscript:`plugin.tx_myextension` — extension-wide defaults, applied to
    every plugin of this extension.
2.  :typoscript:`plugin.tx_myextension_myplugin` — plugin-specific values,
    override the extension-wide layer.
3.  FlexForm data — values the editor entered in the content element's plugin
    tab. These have the highest priority and override both TypoScript layers.
    Only :typoscript:`settings`, :typoscript:`persistence`, and
    :typoscript:`view` keys are merged from the FlexForm.

The resulting array has three top-level keys that Extbase uses directly:

*   :typoscript:`settings` — arbitrary key/value pairs available as
    :php:`$this->settings` in the controller and as :html:`{settings}` in
    Fluid templates (auto-assigned by the framework for frontend plugins).
*   :typoscript:`persistence` — controls record loading; the most relevant
    sub-key is :typoscript:`storagePid`, which limits which page(s) the
    repository queries.
*   :typoscript:`view` — overrides template file resolution via
    :typoscript:`templateRootPaths`, :typoscript:`layoutRootPaths`, and
    :typoscript:`partialRootPaths`.


..  _extbase-registration-frontend-plugin-typoscript:

TypoScript plugin object path
=============================

:php:`configurePlugin()` generates a TypoScript object for the plugin at:

..  code-block:: typoscript

    plugin.tx_<extensionkey>_<pluginname>

Both parts are lowercase; underscores are removed from the extension key. For
the example above that is :typoscript:`plugin.tx_myextension_conferencelist`.
A full example covering all three configuration keys:

..  code-block:: typoscript
    :caption: EXT:my_extension/Configuration/Sets/MyExtension/setup.typoscript

    plugin.tx_myextension_conferencelist {
        view {
            templateRootPaths.10 = EXT:my_extension/Resources/Private/Templates/
        }
        persistence {
            storagePid = {$plugin.tx_myextension_conferencelist.persistence.storagePid}
        }
        settings {
            itemsPerPage = 10
        }
    }

To find the exact TypoScript path of a plugin, open the TYPO3 backend,
navigate to a site or page containing the plugin, and inspect the
computed TypoScript tree in :guilabel:`Site Management > TypoScript`.

..  seealso::

    *   `Non-cacheable actions <https://docs.typo3.org/permalink/extbase-caching-noncacheable>`_
        for the consequences of marking actions non-cacheable and developer
        responsibilities.

    *   `View layer in Extbase <https://docs.typo3.org/permalink/extbase-view-overview>`_
        for template path configuration via TypoScript.

    *   `storagePid — when findAll() returns nothing <https://docs.typo3.org/permalink/extbase-domain-repository-storagepid>`_
        for how the persistence storagePid setting limits which records are
        returned.
