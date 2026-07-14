<?php

use MyVendor\MyExtension\Controller\ConferenceController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin(
    'MyExtension',
    'ConferenceList',
    [ConferenceController::class => 'list, show, create'],
    // The create action persists a new conference and must not be cached:
    [ConferenceController::class => 'create'],
);
