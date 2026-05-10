<?php

declare(strict_types=1);

use MyVendor\MyExtension\Controller\EventController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin(
    'MyExtension',
    'EventList',
    [
        EventController::class => ['list', 'show'],
    ],
);
