<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTCAcolumns(
  'tt_content',
  [
    'tx_examples_noprint' => [
      'exclude' => 0,
      'label' => 'examples.db:tt_content.tx_examples_noprint',
      'config' => [
        'type' => 'check',
        'renderType' => 'checkboxToggle',
        'items' => [
          [
            0 => '',
            1 => '',
          ],
        ],
      ],
    ],
  ],
);
ExtensionManagementUtility::addFieldsToPalette(
  'tt_content',
  'access',
  'tx_examples_noprint',
  'before:editlock',
);
