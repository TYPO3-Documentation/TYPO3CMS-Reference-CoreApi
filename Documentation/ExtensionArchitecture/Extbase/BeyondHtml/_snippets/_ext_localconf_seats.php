<?php

use MyVendor\MyExtension\Controller\ConferenceSeatsController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin(
  'MyExtension',
  'ConferenceSeats',
  [ConferenceSeatsController::class => ['seats']],
  [ConferenceSeatsController::class => ['seats']],
);
