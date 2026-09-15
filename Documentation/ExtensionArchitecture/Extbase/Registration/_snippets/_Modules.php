<?php

declare(strict_types=1);

use MyVendor\MyExtension\Controller\ConferenceController;

return [
  'my_extension_conferences' => [
    'parent' => 'web',
    'position' => ['after' => '*'],
    'access' => 'user',
    'path' => '/module/web/my-extension-conferences',
    'iconIdentifier' => 'my-extension-conference-module',
    'labels' => 'my_extension.modules.conferences',
    'extensionName' => 'MyExtension',
    'controllerActions' => [
      ConferenceController::class => [
        'index', 'show', 'new', 'create', 'edit', 'update', 'delete',
      ],
    ],
  ],
];
