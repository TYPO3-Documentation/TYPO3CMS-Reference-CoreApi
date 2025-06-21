<?php

declare(strict_types=1);

use Psr\Log\LogLevel;
use TYPO3\CMS\Core\Log\Writer\Enum\Interval;
use TYPO3\CMS\Core\Log\Writer\NullWriter;
use TYPO3\CMS\Core\Log\Writer\RotatingFileWriter;

$GLOBALS['TYPO3_CONF_VARS']['LOG']['writerConfiguration'] = [
    LogLevel::WARNING => [
        // Explicitly disable warning level logs
        NullWriter::class => [],
    ],
    LogLevel::ERROR => [
        // Keep error level logs for a week
        RotatingFileWriter::class => [
            'interval' => Interval::DAILY,
            'maxFiles' => 7,
        ],
    ],
    LogLevel::CRITICAL => [
        // Keep critical level logs for eight weeks
        RotatingFileWriter::class => [
            'interval' => Interval::WEEKLY,
            'maxFiles' => 8,
        ],
    ],
];
