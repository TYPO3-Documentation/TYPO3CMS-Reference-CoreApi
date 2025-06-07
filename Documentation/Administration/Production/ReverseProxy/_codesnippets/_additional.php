<?php

use TYPO3\CMS\Core\Core\Environment;

if (Environment::getContext()->isProduction()) {
    $customChanges = [
        // Database Credentials and other production settings
        'SYS' => [
            'reverseProxySSL' => '192.0.2.1,192.168.0.0/16',
        ],
    ];
    $GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customChanges);
}
