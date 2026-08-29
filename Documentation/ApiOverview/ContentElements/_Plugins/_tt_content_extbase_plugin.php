<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::registerPlugin(
    'MyExtension',
    'MyPlugin',
    'my_extension.messages:my_plugin.title',
    'myextension_pluginicon',
    'plugins',
    'my_extension.messages:my_plugin.description',
);
