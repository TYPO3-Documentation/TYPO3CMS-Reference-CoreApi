<?php

declare(strict_types=1);
defined('TYPO3') or die();

// Adds the content element to the "Type" dropdown
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        // title
        'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:myextension_newcontentelement_title',
        // plugin signature: extkey_identifier
        'myextension_newcontentelement',
        // icon identifier
        'content-text',
    ],
    'textmedia',
    'after'
);

// Adds the content element icon to TCA typeicon_classes
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['myextension_newcontentelement'] = 'content-text';

// ...
