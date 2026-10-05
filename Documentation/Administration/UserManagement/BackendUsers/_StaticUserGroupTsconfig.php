<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::registerUserGroupTSConfigFile(
  'my_extension',
  'Configuration/TsConfig/User/NewsEditors.tsconfig',
  'News editors',
);
