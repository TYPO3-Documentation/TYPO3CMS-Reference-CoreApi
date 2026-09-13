<?php

return [
  // ...
  'DB' => [
    'Connections' => [
      'Default' => [
        'charset' => 'utf8mb4',
        'driver' => 'mysqli',
        'dbname' => 'typo3_database',
        'host' => '127.0.0.1',
        'password' => '***',
        'port' => 3306,
        'user' => 'typo3',
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
];
