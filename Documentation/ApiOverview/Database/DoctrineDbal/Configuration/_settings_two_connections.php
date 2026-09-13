<?php

return [
    // ... some configuration
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8',
                'dbname' => 'default_dbname',
                'driver' => 'mysqli',
                'host' => 'default_host',
                'password' => '***',
                'port' => 3306,
                'user' => 'default_user',
            ],
            'Sessions' => [
                'charset' => 'utf8mb4',
                'driver' => 'mysqli',
                'dbname' => 'sessions_dbname',
                'host' => 'sessions_host',
                'password' => '***',
                'port' => 3306,
                'user' => 'some_user',
            ],
        ],
        'TableMapping' => [
            'be_sessions' => 'Sessions',
        ],
    ],
    // ... more configuration
];
