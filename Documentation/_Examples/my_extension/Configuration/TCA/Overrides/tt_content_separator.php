<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

$temporaryColumn = [
  'myextension_separator' => [
    'exclude' => 0,
    'label' => 'Separator',
    'config' => [
      'type' => 'select',
      'renderType' => 'selectSingle',
      'items' => [
        ['label' => 'Standard CSV data formats', 'value' => '--div--'],
        ['label' => 'Comma separated', 'value' => ','],
        ['label' => 'Semicolon separated', 'value' => ';'],
        ['label' => 'Special formats', 'value' => '--div--'],
        ['label' => 'Pipe separated (TYPO3 tables)', 'value' => '|'],
        ['label' => 'Tab separated', 'value' => "\t"],
      ],
      'default' => ',',
    ],
  ],
];
ExtensionManagementUtility::addTCAcolumns('tt_content', $temporaryColumn);
