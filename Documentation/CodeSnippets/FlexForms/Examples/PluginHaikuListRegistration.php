<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project. [...]
 */

use TYPO3\CMS\Core\Schema\Struct\SelectItem;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/*
 * This file is part of the TYPO3 CMS project. [...]
 */

defined('TYPO3') || die();

$pluginSignature = 'examples_haiku_list';

ExtensionManagementUtility::addPlugin(
    new SelectItem(
        'select',
        'LLL:examples.plugin_haiku.db:list.title',
        $pluginSignature,
        'tx_examples-haiku',
        'plugins',
        'LLL:examples.plugin_haiku.db:list.description',
    ),
    'FILE:EXT:examples/Configuration/Flexforms/PluginHaikuList.xml',
);
