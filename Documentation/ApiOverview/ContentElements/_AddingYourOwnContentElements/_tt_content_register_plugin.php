<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::registerPlugin(
    'my_extension',
    'MyPlugin',
    'my_extension.messages:myextension_myplugin_title',
    'myextension_myplugin',
    'plugins',
    'my_extension.messages:myextension_myplugin_description',
);
