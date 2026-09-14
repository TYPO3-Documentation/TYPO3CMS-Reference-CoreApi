<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

// Add some fields to fe_users table to show TCA fields definitions
ExtensionManagementUtility::addTCAcolumns(
  'fe_users',
  [
    'tx_examples_options' => [
      'exclude' => 0,
      'label' => 'examples.db:fe_users.tx_examples_options',
      'config' => [
        'type' => 'select',
        'renderType' => 'selectSingle',
        'items' => [
          ['', 0],
          ['examples.db:fe_users.tx_examples_options.I.0', 1],
          ['examples.db:fe_users.tx_examples_options.I.1', 2],
          ['examples.db:fe_users.tx_examples_options.I.2', '--div--'],
          ['examples.db:fe_users.tx_examples_options.I.3', 3],
        ],
        'size' => 1,
        'maxitems' => 1,
      ],
    ],
    'tx_examples_special' => [
      'exclude' => 0,
      'label' => 'examples.db:fe_users.tx_examples_special',
      'config' => [
        'type' => 'user',
        // renderType needs to be registered in ext_localconf.php
        'renderType' => 'specialField',
        'parameters' => [
          'size' => '30',
          'color' => '#F49700',
        ],
      ],
    ],
  ],
);
ExtensionManagementUtility::addToAllTCAtypes(
  'fe_users',
  'tx_examples_options, tx_examples_special',
);
