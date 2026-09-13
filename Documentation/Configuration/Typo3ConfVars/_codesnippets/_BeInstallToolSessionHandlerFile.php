<?php

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Install\Service\Session\FileSessionHandler;

return [
    // ...
    'BE' => [
        'installToolSessionHandler' => [
            'className' => FileSessionHandler::class,
            'options' => [
                'sessionPath' => Environment::getVarPath() . '/session',
            ],
        ],
    ],
];
