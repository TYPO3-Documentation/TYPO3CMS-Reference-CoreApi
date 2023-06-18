<?php

use TYPO3\CMS\Core\Cache\Backend\RedisBackend;

return [
    // ... other configuration

    'SYS' => [
        'caching' => [
            'cacheConfigurations' => [
                'pages' => [
                    'backend' => RedisBackend::class,
                    'options' => [
                        'database' => 3,
                    ],
                ],
            ],
        ],
    ],
];
