<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::addPlugin(
    [
        'label' => 'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:myextension_myplugin_title',
        'value' => 'myextension_myplugin',
        'icon' => 'content-text',
        'group' => 'plugin',
        'description' => 'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:myextension_myplugin_description',
    ],
);
