<?php

declare(strict_types=1);
defined('TYPO3') or die();

/* See above
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(...);
*/

// Configure the default backend fields for the content element
$GLOBALS['TCA']['tt_content']['types']['myextension_newcontentelement'] = [
    'showitem' => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
               --palette--;;general,
               header; Internal title (not displayed),
               bodytext;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext_formlabel,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
               --palette--;;hidden,
               --palette--;;access,
         ',
    'columnsOverrides' => [
        'bodytext' => [
            'config' => [
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
            ],
        ],
    ],
];
