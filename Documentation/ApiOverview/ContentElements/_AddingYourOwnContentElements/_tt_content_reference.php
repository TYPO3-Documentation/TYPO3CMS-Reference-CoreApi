<?php

declare(strict_types=1);
defined('TYPO3') or die();

$temporaryColumn = [
    'myextension_reference' => [
        'exclude' => 0,
        'label' => 'LLL:EXT:my_extension/Resources/Private/Language/locallang_db.xlf:' .
            'tt_content.myextension_reference',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['None', '0'],
            ],
            'foreign_table' => 'tx_myextension_mytable',
            'foreign_table_where' =>
                'AND {#tx_myextension_mytable}.{#pid} = ###PAGE_TSCONFIG_ID### ' .
                'AND {#tx_myextension_mytable}.{#hidden} = 0 ' .
                'AND {#tx_myextension_mytable}.{#deleted} = 0 ' .
                'ORDER BY sys_category.uid',
            'default' => '0',
        ],
    ],
];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $temporaryColumn);
