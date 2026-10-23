<?php

declare(strict_types=1);

use MyVendor\MyExtension\Controller\CommentModerationController;

return [
  'my_extension_moderation' => [
    // Content modules inherit the page tree of the main module.
    'parent' => 'content',
    'position' => ['after' => 'my_extension_conferences'],
    'access' => 'user',
    'path' => '/module/my-extension/moderation',
    'iconIdentifier' => 'my-extension-moderation-module',
    'labels' => 'my_extension.modules.moderation',
    'extensionName' => 'MyExtension',
    'controllerActions' => [
      CommentModerationController::class => [
        'list',
        'answer',
        'createAnswer',
      ],
    ],
  ],
];
