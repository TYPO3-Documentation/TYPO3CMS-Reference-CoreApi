<?php

declare(strict_types=1);

use MyVendor\MyExtension\Controller\ConferenceController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin(
    'MyExtension',
    'ConferenceList',
    [
        ConferenceController::class => ['list', 'show'],
    ],
);
