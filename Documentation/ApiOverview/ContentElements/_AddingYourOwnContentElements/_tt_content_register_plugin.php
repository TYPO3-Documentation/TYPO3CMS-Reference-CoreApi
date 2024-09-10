<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::registerPlugin(
    'my_extension',
    'MyPlugin',
    'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:myextension_myplugin_title',
    'myextension_myplugin',
    'plugin',
    'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:myextension_myplugin_description',
);
