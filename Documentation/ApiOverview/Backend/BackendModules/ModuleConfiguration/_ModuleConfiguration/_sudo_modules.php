<?php

use TYPO3\CMS\Backend\Security\SudoMode\Access\AccessLifetime;

return [
    'tools_ExtensionmanagerExtensionmanager' => [
        // ...
        'routeOptions' => [
            'sudoMode' => [
                'group' => 'systemMaintainer',
                'lifetime' => AccessLifetime::M,
            ],
        ],
    ],
];
