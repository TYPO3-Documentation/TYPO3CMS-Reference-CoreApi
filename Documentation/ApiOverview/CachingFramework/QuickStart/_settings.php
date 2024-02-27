<?php

use TYPO3\CMS\Core\Cache\Backend\RedisBackend;

return [
    // ...
    'SYS' => [
        // ...
        'caching' => [
            // ...
            'cacheConfigurations' => [
                // ...
                'pages' => [
                    'backend' => RedisBackend::class,
                    'options' => [
                        'database' => 42,
                    ],
                ],
            ],
        ],
    ],
];
