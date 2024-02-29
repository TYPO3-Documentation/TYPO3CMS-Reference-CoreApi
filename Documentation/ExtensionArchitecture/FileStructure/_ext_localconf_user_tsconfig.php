<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::addUserTSConfig(
    '@import "EXT:my_extension/Configuration/defaultUser.tsconfig"',
);
