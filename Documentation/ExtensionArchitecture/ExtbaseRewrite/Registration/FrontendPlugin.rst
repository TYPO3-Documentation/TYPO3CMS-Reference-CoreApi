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

:php:`ExtensionUtility::configurePlugin()` registers the allowed controller
actions and generates the TypoScript needed to route requests to the Extbase
dispatcher. Call it in :file:`ext_localconf.php`:

..  code-block:: php
    :caption: EXT:my_extension/ext_localconf.php

    use MyVendor\MyExtension\Controller\ConferenceController;
    use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

    defined('TYPO3') or die();

    ExtensionUtility::configurePlugin(
        'MyExtension',
        'ConferenceList',
        [ConferenceController::class => 'list, show'],
        [ConferenceController::class => 'list'],
    );

The four arguments:

1.  **Extension name** — the extension key in UpperCamelCase
    (``my_extension`` → ``MyExtension``).
2.  **Plugin name** — a unique UpperCamelCase identifier for this plugin within
    the extension. Combined with the extension name it forms the plugin
    signature used in TypoScript and routing (``myextension_conferencelist``).
    The combined length must not exceed 32 characters.
3.  **Allowed controller actions** — an array mapping controller class names to
    a comma-separated list of action names. The first entry and its first action
    are the default. Only actions listed here are reachable via this plugin.
4.  **Non-cacheable actions** — a subset of the above whose output must not be
    stored in the page cache. See :ref:`extbase-caching-noncacheable`
    for the implications and developer responsibilities.

..  note::

    The fifth parameter ``$pluginType`` was removed in TYPO3 v14. Omit it —
    passing any value other than ``'CType'`` (or omitting it) is the only
    valid option. All plugins are registered as dedicated ``CType`` content
    elements in v14.


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
    );

The arguments:

1.  **Extension name** — same as in :php:`configurePlugin()`.
2.  **Plugin name** — same as in :php:`configurePlugin()`. The two values must
    match exactly.
3.  **Plugin title** — label shown in the backend content element wizard.
    Use a translatable label reference. The example uses the
    :ref:`translation domain syntax <label-reference-domain>` introduced in
    TYPO3 v14 (``extension_key.resource:label_key``), which is shorter than the
    legacy ``LLL:EXT:`` path syntax. Both are equivalent and interchangeable.
4.  **Plugin icon** — an icon identifier registered via the Icon
    :abbr:`API (Application Programming Interface)`, or a path prefixed with
    ``EXT:``. Optional; defaults to the generic plugin icon.
5.  **Group** — groups the plugin in the content element wizard. Common values
    are ``'plugins'`` (generic plugin group) or a custom group name matching
    your extension.
6.  **Description** — optional longer text shown in the content element wizard.

Both calls must use the same extension name and plugin name. A mismatch means
the dispatcher will not find the controller actions registered for that plugin.


..  _extbase-registration-frontend-plugin-typoscript:

TypoScript plugin object path
=============================

:php:`configurePlugin()` generates a TypoScript object for the plugin
automatically. The path follows the pattern:

..  code-block:: typoscript

    plugin.tx_<extensionkey>_<pluginname>

where both parts are lowercased and underscores removed from the extension key.
For the example above:

..  code-block:: typoscript

    plugin.tx_myextension_conferencelist

Use this path to configure view paths, persistence settings, and plugin-specific
TypoScript settings:

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

To find the exact path for an installed plugin, open the TYPO3 backend,
navigate to the site or page where the plugin is placed, and inspect the
assembled TypoScript tree in :guilabel:`Site Management > TypoScript`.

..  seealso::

    *   `Non-cacheable actions <https://docs.typo3.org/permalink/extbase-caching-noncacheable>`_
        — consequences of marking actions non-cacheable and developer
        responsibilities.

    *   `View layer in Extbase <https://docs.typo3.org/permalink/extbase-view-overview>`_
        — template path configuration via TypoScript.

    *   `storagePid — when findAll() returns nothing <https://docs.typo3.org/permalink/extbase-domain-repository-storagepid>`_
        — how the persistence storagePid setting controls which records are
        returned.
