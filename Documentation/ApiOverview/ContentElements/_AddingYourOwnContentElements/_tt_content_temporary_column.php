<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

$temporaryColumn = [
  'myextension_separator' => [
    'exclude' => 0,
    'label' => 'examples.db:tt_content.myextension_separator',
    'config' => [
      'type' => 'select',
      'renderType' => 'selectSingle',
      'items' => [
        ['Standard CSV data formats', '--div--'],
        ['Comma separated', ','],
        ['Semicolon separated', ';'],
        ['Special formats', '--div--'],
        ['Pipe separated (TYPO3 tables)', '|'],
        ['Tab separated', "\t"],
      ],
      'default' => ',',
    ],
  ],
];
ExtensionManagementUtility::addTCAcolumns('tt_content', $temporaryColumn);
