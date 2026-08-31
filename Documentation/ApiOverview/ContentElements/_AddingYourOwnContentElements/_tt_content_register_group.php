<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::addTcaSelectItemGroup(
    'tt_content',
    'CType',
    'myextension_myplugingroup',
    'my_extension.messages:myextension_myplugin.group',
);

ExtensionUtility::registerPlugin(
    'my_extension',
    'MyPlugin',
    'my_extension.messages:myextension_myplugin_title',
    'myextension_myplugin',
    'myextension_myplugingroup',
    'my_extension.messages:myextension_myplugin_description',
);
