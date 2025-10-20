<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$ctypeKey = ExtensionUtility::registerPlugin(
    'MyExtension',
    'MyPlugin',
    'My Plugin Title',
    'my-extension-icon',
    'plugins',
    'Plugin description',
    'FILE:EXT:my_extension/Configuration/FlexForms/MyFlexform.xml',
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
