<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$ctypeKey = 'my_plugin';

// Plain plugin without Extbase controller
ExtensionManagementUtility::addPlugin(
    [
        'My Plugin Title',
        $ctypeKey,
        'my-extension-icon',
    ],
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;Configuration,pi_flexform,',
    $ctypeKey,
    'after:subheader',
);

ExtensionManagementUtility::addPiFlexFormValue(
    '',
    'FILE:EXT:myext/Configuration/FlexForms/MyFlexform.xml',
    $ctypeKey,
);
