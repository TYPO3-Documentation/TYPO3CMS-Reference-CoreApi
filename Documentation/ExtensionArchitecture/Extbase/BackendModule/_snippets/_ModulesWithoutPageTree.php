<?php

use MyVendor\MyExtension\Controller\ConferenceModuleController;

return [
  'my_extension_conferences' => [
    'parent' => 'content',
    'position' => ['after' => 'records'],
    'access' => 'user',
    'path' => '/module/my-extension/conferences',
    'iconIdentifier' => 'my-extension-conference-module',
    'labels' => 'my_extension.modules.conferences',
    // Content modules show the page tree by default. This one does not.
    'inheritNavigationComponentFromMainModule' => false,
    'extensionName' => 'MyExtension',
    'controllerActions' => [
      ConferenceModuleController::class => [
        'list',
      ],
    ],
  ],
];
