<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$pluginSignature = ExtensionUtility::registerPlugin(
    'Examples',
    'HtmlParser',
    'examples.plugins.htmlparser:title',
    null,
    'plugins',
    'examples.plugins.htmlparser:description',
    'FILE:EXT:examples/Configuration/FlexForms/Registration.xml',
);
