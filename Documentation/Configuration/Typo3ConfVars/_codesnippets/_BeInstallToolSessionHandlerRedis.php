<?php

use TYPO3\CMS\Install\Service\Session\RedisSessionHandler;

return [
  // ...
  'BE' => [
    'installToolSessionHandler' => [
      'className' => RedisSessionHandler::class,
      'options' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'database' => 0,
        'authentication' => [
          'user' => 'redis',
          'pass' => 'redis',
        ],
      ],
    ],
  ],
];
