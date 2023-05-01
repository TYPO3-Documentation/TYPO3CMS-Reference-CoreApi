<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\Writer\FileWriter;

defined('TYPO3') or die();

// Add example configuration for the logging API
$GLOBALS['TYPO3_CONF_VARS']['LOG']['MyVendor']['MyExtension']['MyClass']['writerConfiguration'] = [
    // Configuration for ERROR level log entries
    LogLevel::ERROR => [
        // Add a FileWriter
        FileWriter::class => [
            // Configuration for the writer
            'logFile' => Environment::getVarPath() . '/log/my_extension.log',
        ],
    ],
];
