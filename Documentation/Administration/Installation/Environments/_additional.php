<?php

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport']
    = $_ENV['TYPO3_MAIL_TRANSPORT'];
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server']
    = $_ENV['TYPO3_MAIL_TRANSPORT_SMTP_SERVER'];
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username']
    = $_ENV['TYPO3_MAIL_TRANSPORT_SMTP_USERNAME'];
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password']
    = $_ENV['TYPO3_MAIL_TRANSPORT_SMTP_PASSWORD'];

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname']
    = $_ENV['TYPO3_DB_DBNAME'];
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host']
    = $_ENV['TYPO3_DB_HOST'];
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password']
    = $_ENV['TYPO3_DB_PASSWORD'];
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user']
    = $_ENV['TYPO3_DB_USER'];

$GLOBALS['TYPO3_CONF_VARS']['BE']['lockRootPath'] = [
    $_ENV['TYPO3_BE_LOCKROOTPATH'],
];
