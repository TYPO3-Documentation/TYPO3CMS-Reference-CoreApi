<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::addPlugin(
    [
        'label' => 'my_extension.db:my_plugin.title',
        'value' => 'myextension_myplugin',
        'group' => 'plugins',
        'icon' => 'myextension_mypluginicon',
        'description' => 'my_extension.db:my_plugin.description',
    ],
    'CType',
    'my_extension',
);
