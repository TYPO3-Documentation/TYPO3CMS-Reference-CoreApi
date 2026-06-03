<?php

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
