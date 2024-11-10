<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$pluginSignature = 'examples_pi1';
$pluginTitle = 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1';
$extensionKey = 'examples';

// Add the plugins to the list of plugins
ExtensionManagementUtility::addPlugin(
    [
        $pluginTitle,
        $pluginSignature,
    ],
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;Configuration,pi_flexform,',
    $pluginSignature,
    'after:header',
);

ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:example/Configuration/FlexForms/Registration.xml',
    $pluginSignature,
);
