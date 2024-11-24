<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::addStaticFile(
    'my_extension',
    'Configuration/TypoScript/',
    'Examples TypoScript',
);
