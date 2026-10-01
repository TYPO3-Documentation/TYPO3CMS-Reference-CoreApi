<?php

return [
  'frontend' => [
    'middleware-identifier' => [
      'target' => \MyVendor\MyExtension\Middleware\ConcreteClass::class,
      'before' => [
        'another-middleware-identifier',
      ],
      'after' => [
        'yet-another-middleware-identifier',
      ],
    ],
  ],
  'backend' => [
    'middleware-identifier' => [
      'target' => \MyVendor\MyExtension\Middleware\AnotherConcreteClass::class,
      'before' => [
        'another-middleware-identifier',
      ],
      'after' => [
        'yet-another-middleware-identifier',
      ],
    ],
  ],
];
