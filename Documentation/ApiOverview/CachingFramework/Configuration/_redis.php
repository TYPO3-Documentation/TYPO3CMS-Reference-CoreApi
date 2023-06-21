<?php

use TYPO3\CMS\Core\Cache\Backend\RedisBackend;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['pages'] = [
    'backend' => RedisBackend::class,
    'options' => [
        'database' => 3,
    ],
];
