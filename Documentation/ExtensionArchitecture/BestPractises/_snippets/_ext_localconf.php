<?php

use T3docs\Examples\Controller\HtmlParserController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

ExtensionUtility::configurePlugin(
    'Examples',
    'HtmlParser',
    [
        HtmlParserController::class => 'index',
    ],
    [
        HtmlParserController::class => 'index',
    ],
);
