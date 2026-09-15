<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addTcaSelectItem(
  'pages',
  'module',
  [
    'label' => 'Conference plugin',
    'value' => 'conferences',
  ],
);
