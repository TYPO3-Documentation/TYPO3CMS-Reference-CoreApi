<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$GLOBALS['TCA'][$myTable]['columns']['categories'] = [
  'config' => [
    'type' => 'category',
  ],
];

ExtensionManagementUtility::addToAllTCAtypes(
  $myTable,
  'categories',
);
