<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::registerPlugin(
    'MyExtension',
    'ConferenceList',
    'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:plugin.conferencelist.title',
    'EXT:my_extension/Resources/Public/Icons/Extension.svg',
);
