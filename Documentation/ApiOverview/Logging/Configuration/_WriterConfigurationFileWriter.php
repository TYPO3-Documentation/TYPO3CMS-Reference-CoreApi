<?php

use Psr\Log\LogLevel;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Log\Writer\FileWriter;

$GLOBALS['TYPO3_CONF_VARS']['LOG']['writerConfiguration'] = [
  // Configuration for ERROR level log entries
  LogLevel::ERROR => [
    // Add a FileWriter
    FileWriter::class => [
      // Configuration for the writer
      'logFile' => Environment::getVarPath()
          . '/log/typo3_7ac500bce5.log',
    ],
  ],
];
