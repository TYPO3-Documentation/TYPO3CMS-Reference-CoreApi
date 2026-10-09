<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::registerUserTSConfigFile(
  'my_extension',
  'Configuration/TsConfig/User/Editor.tsconfig',
  'Editor',
);
