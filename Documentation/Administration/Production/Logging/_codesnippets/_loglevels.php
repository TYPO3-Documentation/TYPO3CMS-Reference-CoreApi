<?php

declare(strict_types=1);

use Psr\Log\LogLevel;
use TYPO3\CMS\Core\Log\Writer\FileWriter;
use TYPO3\CMS\Core\Log\Writer\NullWriter;

$GLOBALS['TYPO3_CONF_VARS']['LOG']['writerConfiguration'] = [
    LogLevel::WARNING => [
        // Explicitly disable warning level logs
        NullWriter::class => [],
    ],
    LogLevel::ERROR => [
        FileWriter::class => [],
    ],
];
