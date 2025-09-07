<?php

$redisHost = '127.0.0.1';
$redisPort = 6379;
$redisCaches = [
    'pages' => [
        'defaultLifetime' => 86400 * 7, // 1 week
        'compression' => true,
    ],
    'pagesection' => [
        'defaultLifetime' => 86400 * 7,
    ],
    'hash' => [],
    'rootline' => [],
];

$redisDatabase = 0;
foreach ($redisCaches as $name => $values) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$name]['backend']
        = \TYPO3\CMS\Core\Cache\Backend\RedisBackend::class;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$name]['options'] = [
        'database' => $redisDatabase++,
        'hostname' => $redisHost,
        'port' => $redisPort,
    ];
    if (isset($values['defaultLifetime'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$name]['options']['defaultLifetime']
            = $values['defaultLifetime'];
    }
    if (isset($values['compression'])) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$name]['options']['compression']
            = $values['compression'];
    }
}
