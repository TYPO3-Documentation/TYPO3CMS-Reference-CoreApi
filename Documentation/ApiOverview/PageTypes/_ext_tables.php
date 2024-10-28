<?php

use TYPO3\CMS\Core\DataHandling\PageDoktypeRegistry;
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3') or die();

// Define a new doktype
$customPageDoktype = 116;
// Add page type to system
$dokTypeRegistry = GeneralUtility::makeInstance(PageDoktypeRegistry::class);
$dokTypeRegistry->add(
    $customPageDoktype,
    [
        'allowedTables' => '*',
    ],
);
