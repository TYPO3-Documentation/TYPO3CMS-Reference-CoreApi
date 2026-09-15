<?php

return [
  'SYS' => [
    'session' => [
      'BE' => [
        'backend' => \TYPO3\CMS\Core\Session\Backend\RedisSessionBackend::class,
        'options' => [
          'hostname' => 'redis.myhost.example',
          'password' => 'passw0rd',
          'database' => 0,
          'port' => 6379,
          'keyPrefix' => 'be_sessions_',
        ],
      ],
      'FE' => [
        'backend' => \TYPO3\CMS\Core\Session\Backend\RedisSessionBackend::class,
        'options' => [
          'hostname' => 'redis.myhost.example',
          'password' => 'passw0rd',
          'database' => 0,
          'port' => 6379,
          'keyPrefix' => 'fe_sessions_',
        ],
      ],
    ],
  ],
];
