<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

// Plain plugin without Extbase controller
ExtensionManagementUtility::addPlugin(
    [
        'My Plugin Title',
        'my_plugin',
        'my-extension-icon',
    ],
    'FILE:EXT:myext/Configuration/FlexForms/MyFlexform.xml',
);
