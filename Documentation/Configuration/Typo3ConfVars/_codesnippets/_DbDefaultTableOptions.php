<?php

return [
    // ...
    'DB' => [
        'Connections' => [
            'Default' => [
                'driver' => 'mysqli',
                // ...
                'charset' => 'utf8mb4',
                'defaultTableOptions' => [
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                ],
            ],
        ],
    ],
];
