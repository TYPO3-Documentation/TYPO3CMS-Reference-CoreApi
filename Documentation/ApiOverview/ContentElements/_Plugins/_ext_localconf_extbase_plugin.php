<?php

declare(strict_types=1);
defined('TYPO3') or die();

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use MyVendor\MyExtension\Controler\MyController;

ExtensionUtility::configurePlugin(
    'MyExtension',
    'MyPlugin',
    [MyController::class => 'list,comment'],
    [MyController::class => 'comment'],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);
