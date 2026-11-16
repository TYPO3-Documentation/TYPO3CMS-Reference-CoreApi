<?php

declare(strict_types=1);

use MyVendor\MyExtension\Middleware\ConferenceSeatsMiddleware;

return [
  'frontend' => [
    'myvendor/my-extension/conference-seats' => [
      'target' => ConferenceSeatsMiddleware::class,
      'after' => [
        'typo3/cms-frontend/authentication',
      ],
      'before' => [
        'typo3/cms-frontend/page-resolver',
      ],
    ],
  ],
];
