<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$pluginSignature = 'examples_pi1';

// Add the plugins to the list of plugins
ExtensionManagementUtility::addPlugin(
    [
        'examples.db:tt_content.list_type_pi1',
        $pluginSignature,
    ],
    'FILE:EXT:examples/Configuration/FlexForms/Registration.xml',
);
