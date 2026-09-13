<?php

use TYPO3\CMS\Core\Cache\Backend\RedisBackend;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['pages']['backend']
    = RedisBackend::class;
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['pages']['options']
    = [
      'defaultLifetime' => 86400,
      'database' => 0,
      'hostname' => 'redis',
      'port' => 6379,
      'username' => 'redis',
      'password' => 'redis',
    ];
