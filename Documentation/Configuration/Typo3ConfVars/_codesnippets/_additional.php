<?php

use TYPO3\CMS\Core\Core\Environment;

$applicationContext = Environment::getContext();

if ($applicationContext->isDevelopment()) {
    $GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive(
        $GLOBALS['TYPO3_CONF_VARS'],
        [
            // Use DDEV default database credentials during development
            'DB' => [
                'Connections' => [
                    'Default' => [
                        'dbname' => 'db',
                        'driver' => 'mysqli',
                        'host' => 'db',
                        'password' => 'db',
                        'port' => '3306',
                        'user' => 'db',
                    ],
                ],
            ],
            // This mail configuration sends all emails to mailpit
            'MAIL' => [
                'transport' => 'smtp',
                'transport_smtp_encrypt' => false,
                'transport_smtp_server' => 'localhost:1025',
            ],
            // Allow all .ddev.site hosts
            'SYS' => [
                'trustedHostsPattern' => '.*.ddev.site',
            ],
        ],
    );
}
