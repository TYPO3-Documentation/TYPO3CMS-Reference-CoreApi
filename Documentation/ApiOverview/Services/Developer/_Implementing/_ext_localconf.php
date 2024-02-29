<?php

declare(strict_types=1);

use Foo\Babelfish\Service\Translator;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::addService(
    // Extension Key
    'babelfish',
    // Service type
    'translator',
    // Service key
    'tx_babelfish_translator',
    [
        'title' => 'Babelfish',
        'description' => 'Guess alien languages by using a babelfish',

        'subtype' => '',

        'available' => true,
        'priority' => 60,
        'quality' => 80,

        'os' => '',
        'exec' => '',

        'className' => Translator::class,
    ],
);
