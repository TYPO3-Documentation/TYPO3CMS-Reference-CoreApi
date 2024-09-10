<?php

use MyVendor\MyExtension\Handlers\MyHandler;
use TYPO3\CMS\Backend\Security\SudoMode\Access\AccessLifetime;

return [
    'my-route' => [
        'path' => '/my/route',
        'target' => MyHandler::class . '::process',
        'sudoMode' => [
            'group' => 'mySudoModeGroup',
            'lifetime' => AccessLifetime::S,
        ],
    ],
];
