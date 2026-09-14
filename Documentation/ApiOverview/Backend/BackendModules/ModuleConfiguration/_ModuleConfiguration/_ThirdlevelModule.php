<?php

declare(strict_types=1);

use MyVendor\MyExtension\Controller\CustomInfoController;

return [
  'web_ts_customts' => [
    'parent' => 'content_status',
    'access' => 'user',
    'path' => '/module/content/typoscript/custom-info',
    'iconIdentifier' => 'module-custom-info',
    'labels' => [
      'title' => 'extkey.messages:mod_title',
    ],
    'routes' => [
      '_default' => [
        'target' => CustomInfoController::class . '::handleRequest',
      ],
    ],
    'moduleData' => [
      'someOption' => false,
    ],
  ],
];
