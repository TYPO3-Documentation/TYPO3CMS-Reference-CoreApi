<?php

use Psr\Log\LogLevel;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Log\Writer\FileWriter;

if (Environment::getContext()->isDevelopment()) {
    $GLOBALS['TYPO3_CONF_VARS']['LOG']['TYPO3']['CMS']['deprecations']
    ['writerConfiguration'][LogLevel::NOTICE][FileWriter::class]
    ['disabled'] = false;
}
