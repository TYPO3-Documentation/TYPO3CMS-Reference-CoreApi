<?php

declare(strict_types=1);

use Psr\Log\LogLevel;
use TYPO3\CMS\Core\Log\Writer\Enum\Interval;
use TYPO3\CMS\Core\Log\Writer\RotatingFileWriter;

$GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['deprecations']['writerConfiguration'][LogLevel::NOTICE] = [
    RotatingFileWriter::class => [
        'logFileInfix' => 'deprecations',
        'interval' => Interval::WEEKLY,
        'maxFiles' => 4,
        'disabled' => false,
    ],
];
