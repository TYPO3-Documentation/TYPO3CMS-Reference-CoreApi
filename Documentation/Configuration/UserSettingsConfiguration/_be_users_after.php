<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addUserSetting(
  'myCustomSetting',
  [
    'label' => 'my_extension.messages:myCustomSetting',
    'config' => [
      'type' => 'check',
      'renderType' => 'checkboxToggle',
    ],
  ],
  'after:emailMeAtLogin',
);
