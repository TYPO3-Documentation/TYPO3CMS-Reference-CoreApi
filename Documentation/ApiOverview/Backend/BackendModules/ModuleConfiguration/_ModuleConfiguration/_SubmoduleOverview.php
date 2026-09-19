<?php

declare(strict_types=1);

use MyVendor\MyExtension\Controller\SpeakerController;
use MyVendor\MyExtension\Controller\TalkController;

return [
  'my_extension_conference' => [
    'parent' => 'content',
    'access' => 'user',
    'path' => '/module/content/conference',
    'iconIdentifier' => 'my-extension-conference',
    'labels' => [
      'title' => 'my_extension.modules:conference.title',
    ],
    // Show the submodules as cards instead of opening the first one
    'showSubmoduleOverview' => true,
  ],
  'my_extension_conference_talks' => [
    'parent' => 'my_extension_conference',
    'access' => 'user',
    'path' => '/module/content/conference/talks',
    'iconIdentifier' => 'my-extension-conference-talks',
    'labels' => [
      'title' => 'my_extension.modules:conference.talks.title',
      // Shown on the card of this module
      'description' => 'my_extension.modules:conference.talks.description',
    ],
    'routes' => [
      '_default' => [
        'target' => TalkController::class . '::handleRequest',
      ],
    ],
  ],
  'my_extension_conference_speakers' => [
    'parent' => 'my_extension_conference',
    'access' => 'user',
    'path' => '/module/content/conference/speakers',
    'iconIdentifier' => 'my-extension-conference-speakers',
    'labels' => [
      'title' => 'my_extension.modules:conference.speakers.title',
      'description' => 'my_extension.modules:conference.speakers.description',
    ],
    'routes' => [
      '_default' => [
        'target' => SpeakerController::class . '::handleRequest',
      ],
    ],
  ],
];
