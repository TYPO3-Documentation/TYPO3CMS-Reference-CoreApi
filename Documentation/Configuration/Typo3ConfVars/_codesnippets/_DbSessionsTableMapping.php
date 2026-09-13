<?php

return [
  // ...
  'DB' => [
    'Connections' => [
      'Default' => [
        // ...
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
