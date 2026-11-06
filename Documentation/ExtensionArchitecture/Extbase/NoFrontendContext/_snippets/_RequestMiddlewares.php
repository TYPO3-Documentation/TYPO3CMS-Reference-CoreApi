<?php

declare(strict_types=1);

use MyVendor\MyExtension\Middleware\ConferenceApiMiddleware;

return [
  'frontend' => [
    'myvendor/my-extension/conference-api' => [
      'target' => ConferenceApiMiddleware::class,
      'after' => [
        'typo3/cms-frontend/site',
      ],
      'before' => [
        'typo3/cms-frontend/page-resolver',
      ],
    ],
  ],
];
