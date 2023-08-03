<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

// Add custom doktype to the page tree toolbar
ExtensionManagementUtility::addUserTSConfig(
    "@import 'EXT:examples/Configuration/TsConfig/User/*.tsconfig'"
);
