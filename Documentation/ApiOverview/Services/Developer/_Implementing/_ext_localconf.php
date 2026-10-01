<?php

declare(strict_types=1);

use MyVendor\MyExtension\Service\Translator;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::addService(
  // Extension Key
  'my_extension',
  // Service type
  'translator',
  // Service key
  'tx_myextension_translator',
  [
    'title' => 'Babelfish',
    'description' => 'Guess alien languages by using a babelfish',

    'subtype' => '',

    'available' => true,
    'priority' => 60,
    'quality' => 80,

    'os' => '',
    'exec' => '',

    'className' => Translator::class,
  ],
);
