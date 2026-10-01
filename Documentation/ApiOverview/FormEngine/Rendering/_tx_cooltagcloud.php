<?php

defined('TYPO3') or die();

$GLOBALS['TCA']['tx_myextension_tagcloud']['columns']['my_field'] = [
  'label' => 'Cool Tag cloud',
  'config' => [
    'type' => 'select',
    'renderType' => 'selectTagCloud',
    'foreign_table' => 'tx_myextension_tag',
  ],
];
