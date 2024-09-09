<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::registerPlugin(
    'MyExtension',
    'MyPlugin',
    'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:my_plugin.title',
    'myextension_pluginicon',
    'plugins',
    'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:my_plugin.description',
);
