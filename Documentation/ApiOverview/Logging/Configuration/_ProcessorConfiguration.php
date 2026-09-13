<?php

use Psr\Log\LogLevel;
use TYPO3\CMS\Core\Log\Processor\MemoryUsageProcessor;

$GLOBALS['TYPO3_CONF_VARS']['LOG']['T3docs']['Examples']['Controller']
    ['processorConfiguration'] = [
      // Configuration for ERROR level log entries
      LogLevel::ERROR => [
        // Add a MemoryUsageProcessor
        MemoryUsageProcessor::class => [
          'formatSize' => true,
        ],
      ],
    ];
