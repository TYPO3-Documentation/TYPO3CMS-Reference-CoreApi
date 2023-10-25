<?php

declare(strict_types=1);
defined('TYPO3') or die();

// Adds the content element to the "Type" dropdown
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        // title
        'label' => 'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:myextension_newcontentelement_title',
        // plugin signature: extkey_identifier
        'value' => 'myextension_newcontentelement',
        // icon identifier
        'icon' => 'content-text',
        // group
        'group' => 'common',
    ],
    'textmedia',
    'after'
);

// ...
