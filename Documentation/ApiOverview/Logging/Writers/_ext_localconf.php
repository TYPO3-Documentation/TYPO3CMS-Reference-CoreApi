<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\Writer\DatabaseWriter;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['LOG']['T3docs']['Examples']['Controller']['writerConfiguration'] = [
    LogLevel::DEBUG => [
        DatabaseWriter::class => [
            'logTable' => 'tx_examples_log',
        ],
    ],
];
