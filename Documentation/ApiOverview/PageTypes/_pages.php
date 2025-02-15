<?php

defined('TYPO3') or die();

// encapsulate all locally defined variables
(function () {
    // SAME as registered in ext_tables.php
    $customPageDoktype = 116;
    $customIconClass = 'tx-examples-archive-page';

    // Add the new doktype to the page type selector
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
        'pages',
        'doktype',
        [
            'label' => 'LLL:EXT:examples/Resources/Private/Language/locallang.xlf:archive_page_type',
            'value' => $customPageDoktype,
            'icon'  => $customIconClass,
            'group' => 'special',
        ],
    );

    // Add the icon to the icon class configuration
    $GLOBALS['TCA']['pages']['ctrl']['typeicon_classes'][$customPageDoktype] = $customIconClass;
})();
