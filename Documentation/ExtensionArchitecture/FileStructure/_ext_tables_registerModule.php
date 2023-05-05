<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

$versionInformation = GeneralUtility::makeInstance(Typo3Version::class);

if ($versionInformation->getMajorVersion() < 12) {
    ExtensionUtility::registerModule(
        'ExtensionName', // Extension Name in CamelCase
        'web', // the main module
        'mysubmodulekey', // Submodule key
        'bottom', // Position
        [
            'MyController' => 'list,show,new',
        ],
        [
            'access' => 'user,group',
            'icon'   => 'EXT:my_extension/ext_icon.svg',
            'labels' => 'LLL:EXT:my_extension/Resources/Private/Language/locallang_statistics.xlf',
        ]
    );
}
