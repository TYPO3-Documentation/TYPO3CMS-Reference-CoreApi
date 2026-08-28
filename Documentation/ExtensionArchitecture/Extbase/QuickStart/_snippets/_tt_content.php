<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::registerPlugin(
    'MyExtension',
    'ConferenceList',
    'my_extension.messages:plugin.conferencelist.title',
    'content-plugin',
);
