<?php

$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = 'smtp';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server'] = 'localhost';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_encrypt'] = true;
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username'] = 'johndoe';
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password'] = 'cooLSecret';
// Fetches all 'returning' emails:
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress']
    = 'bounces@example.org';
