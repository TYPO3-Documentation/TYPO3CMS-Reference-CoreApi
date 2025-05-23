<?php

use Psr\Log\LogLevel;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Log\Writer\FileWriter;

// Other settings

$GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['Core']['Authentication']['writerConfiguration'] = [
    LogLevel::INFO => [
        FileWriter::class => [
            'logFile' => Environment::getVarPath() . '/log/typo3_auth.log',
        ],
    ],
];
