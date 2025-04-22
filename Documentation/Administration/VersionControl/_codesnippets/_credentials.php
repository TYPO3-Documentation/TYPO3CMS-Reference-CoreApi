<?php

defined('TYPO3') or die();
$customChanges = [
    'BE' => [
        'installToolPassword' => 'secret',
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
                'password' => 'secret',
            ],
        ],
    ],
    'EXTENSIONS' => [
        't3monitoring_client' => [
            'secret' => 'secret',
        ],
    ],
    'SYS' => [
        'encryptionKey' => 'also secret',
    ],
];
