..  include:: /Includes.rst.txt
..  index:: ! File; EXT:{extkey}/ext_tables.php
..  _database-exttables-sql:
..  _ext-tables-php:
..  _ext-tables-php-not-use:
..  _ext-tables-php-usage:
..  _ext-tables-php-examples:
..  _extension-configuration-files-scheduler:
..  _admin-tools-upgrade-tca-ext-tables:

=============================
`ext_tables.php` (Deprecated)
=============================

..  deprecated:: 14.3
    Using the `ext_tables.php` file in extensions is deprecated.

..  typo3:file:: ext_tables.php
    :scope: extension
    :regex: /^.*ext\_tables\.php$/
    :shortDescription: This file is deprecated.

    This file is deprecated. It was historically used to register backend
    modules, page doktypes, user settings, and other runtime configuration.
    All of these use cases now have dedicated alternatives in modern TYPO3.

..  _ext-tables-php-migration:

Migration: Move registrations from `ext_tables.php`
===================================================

Move all registrations from :file:`ext_tables.php` to the appropriate
configuration files.

..  rubric:: User settings:

User settings previously registered via
:php:`ExtensionManagementUtility::addFieldsToUserSettings()` in
:file:`ext_tables.php` should now be added via
:php:`ExtensionManagementUtility::addUserSetting()` in
:file:`Configuration/TCA/Overrides/be_users.php`.

Before:

..  code-block:: php
    :caption: ext_tables.php

    $GLOBALS['TYPO3_USER_SETTINGS']['columns']['myCustomSetting'] = [
        'type' => 'check',
        'label' => 'LLL:EXT:my_ext/Resources/Private/Language/locallang.xlf:myCustomSetting',
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToUserSettings(
        'myCustomSetting',
        'after:emailMeAtLogin'
    );

After:

..  code-block:: php
    :caption: Configuration/TCA/Overrides/be_users.php

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserSetting(
        'myCustomSetting',
        [
            'label' => 'LLL:EXT:my_ext/Resources/Private/Language/locallang.xlf:myCustomSetting',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
            ],
        ],
        'after:emailMeAtLogin'
    );

..  rubric:: Page type allowed record types:

Page doktypes previously registered via :php:`PageDoktypeRegistry->add()` in
:file:`ext_tables.php` should now use the TCA option
:php:`allowedRecordTypes` in :file:`Configuration/TCA/Overrides/pages.php`.

..  seealso:: `Create new page type <https://docs.typo3.org/permalink/t3coreapi:page-types-example>`_

Before:

..  code-block:: php
    :caption: ext_tables.php

    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\DataHandling\PageDoktypeRegistry::class
    )->add(116, [
        'allowedTables' => ['tt_content', 'my_custom_record'],
    ]);

After:

..  code-block:: php
    :caption: Configuration/TCA/Overrides/pages.php

    $GLOBALS['TCA']['pages']['types']['116']['allowedRecordTypes'] = [
        'tt_content',
        'my_custom_record',
    ];

Once all registrations have been moved and TYPO3 V13 support is dropped, the
:file:`ext_tables.php` file can be removed from the extension.
