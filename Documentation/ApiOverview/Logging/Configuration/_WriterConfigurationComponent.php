<?php

use Psr\Log\LogLevel;
use TYPO3\CMS\Core\Log\Writer\SyslogWriter;

$GLOBALS['TYPO3_CONF_VARS']['LOG']['T3docs']['Examples']['Controller']
    ['writerConfiguration'] = [
      // Configuration for WARNING severity, including all
      // levels with higher severity (ERROR, CRITICAL, EMERGENCY)
      LogLevel::WARNING => [
        // Add a SyslogWriter
        SyslogWriter::class => [],
      ],
    ];
