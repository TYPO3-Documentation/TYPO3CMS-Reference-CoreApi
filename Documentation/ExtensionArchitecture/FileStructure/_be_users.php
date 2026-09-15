<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addUserSetting(
  'myCustomSetting',
  [
    'label' => 'my_ext.messages:myCustomSetting',
    'config' => [
      'type' => 'check',
      'renderType' => 'checkboxToggle',
    ],
  ],
  'after:emailMeAtLogin',
);
