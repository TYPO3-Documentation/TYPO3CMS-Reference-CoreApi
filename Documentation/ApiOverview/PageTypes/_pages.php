<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Schema\Struct\SelectItem;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    $customPageDoktype = '116';
    $customIconClass = 'tx-examples-archive-page';

    $GLOBALS['TCA']['pages']['types'][$customPageDoktype] = $GLOBALS['TCA']['pages']['types'][1];
    $GLOBALS['TCA']['pages']['types'][$customPageDoktype]['allowedRecordTypes'] = ['*'];
    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$customPageDoktype] = $customIconClass;

    ExtensionManagementUtility::addTcaSelectItem(
        'pages',
        'doktype',
        new SelectItem(
            label: 'LLL:EXT:examples/Resources/Private/Language/locallang.xlf:archive_page_type',
            value: $customPageDoktype,
            icon: $customIconClass,
            group: 'special',
        ),
    );
})();
