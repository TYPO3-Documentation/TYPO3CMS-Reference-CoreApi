<?php

declare(strict_types=1);
defined('TYPO3') or die();

use MyVendor\MyExtension\Controler\MyController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

ExtensionUtility::configurePlugin(
    'MyExtension',
    'MyPlugin',
    [MyController::class => 'list,comment'],
    [MyController::class => 'comment'],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);
