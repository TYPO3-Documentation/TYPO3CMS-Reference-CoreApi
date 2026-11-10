<?php

use MyVendor\MyExtension\Controller\ConferenceController;
use MyVendor\MyExtension\Controller\ConferenceFeedController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin(
  'MyExtension',
  'ConferenceList',
  [ConferenceController::class => 'list'],
);

ExtensionUtility::configurePlugin(
  'MyExtension',
  'ConferenceFeed',
  [ConferenceFeedController::class => 'feed'],
);
