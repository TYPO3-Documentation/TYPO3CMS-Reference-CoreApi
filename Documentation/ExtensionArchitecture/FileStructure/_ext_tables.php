<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$GLOBALS['TYPO3_USER_SETTINGS']['columns']['myCustomSetting'] = [
  'type' => 'check',
  'label' => 'my_ext.messages:myCustomSetting',
];
ExtensionManagementUtility::addFieldsToUserSettings(
  'myCustomSetting',
  'after:emailMeAtLogin',
);
