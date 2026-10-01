<?php

return [
  'SYS' => [
    'session' => [
      'FE' => [
        'backend' => \MyVendor\MyExtension\Session\MyCustomSessionBackend::class,
        'options' => [
          'foo' => 'bar',
        ],
      ],
    ],
  ],
];
