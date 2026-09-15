<?php

use MyVendor\MyExtension\Controller\ConferenceController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin(
  'MyExtension',
  'ConferenceList',
  [ConferenceController::class => 'list, show, create'],
  [ConferenceController::class => 'create'],
);
