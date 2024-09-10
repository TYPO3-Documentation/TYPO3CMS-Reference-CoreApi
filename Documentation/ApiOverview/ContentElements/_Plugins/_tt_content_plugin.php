<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::addPlugin(
    [
        'label' => 'LLL:EXT:my_extension/Resources/Private/Language/locallang_db.xlf:my_plugin.title',
        'value' => 'myextension_myplugin',
        'group' => 'plugins',
        'icon' => 'myextension_mypluginicon',
        'description' => 'LLL:EXT:my_extension/Resources/Private/Language/locallang_db.xlf:my_plugin.description',
    ],
    'CType',
    'my_extension',
);
