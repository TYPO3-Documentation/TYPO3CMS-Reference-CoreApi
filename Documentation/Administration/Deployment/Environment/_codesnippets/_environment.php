<?php

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport']
    = 'smtp';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server']
    = 'smtp.example.com:25';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username']
    = 'info@example.com';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password']
    = 'verySafeAndSecretPassword0815!';

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname']
    = 'typo3';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host']
    = 'db.example.com';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password']
    = 'verySafeAndSecretPassword0815!';
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user']
    = 'typo3';

$GLOBALS['TYPO3_CONF_VARS']['BE']['lockRootPath'] = [
    '/var/www/shared/files/',
];
