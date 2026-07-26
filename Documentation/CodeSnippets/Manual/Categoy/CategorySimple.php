<?php

$GLOBALS['TCA'][$myTable]['columns']['categories'] = [
    'config' => [
        'type' => 'category',
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    $myTable,
    'categories',
);
