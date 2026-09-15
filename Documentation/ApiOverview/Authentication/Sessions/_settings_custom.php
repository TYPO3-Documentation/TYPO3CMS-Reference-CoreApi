<?php

return [
  'SYS' => [
    'session' => [
      'FE' => [
        'backend' => \Vendor\Sessions\MyCustomSessionBackend::class,
        'options' => [
          'foo' => 'bar',
        ],
      ],
    ],
  ],
];
