<?php

defined('TYPO3') or die();

// encapsulate all locally defined variables
(function () {
    // SAME as registered in ext_tables.php
    $customPageDoktype = 116;
    $customIconClass = 'tx_examples-archive-page';

    // Add the new doktype to the page type selector
    $GLOBALS['TCA']['pages']['columns']['doktype']['config']['items'][] = [
        'LLL:EXT:examples/Resources/Private/Language/locallang.xlf:archive_page_type',
        $customPageDoktype,
        $customIconClass,
    ];
    // Add the icon to the icon class configuration
    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$customPageDoktype] = 'tx_examples-archive-page';
})();
