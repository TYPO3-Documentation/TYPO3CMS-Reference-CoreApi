<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Extension title',
    // ...
    'autoload' => [
        'psr-4' => [
            // The prefix must end with a backslash
            'Vendor\\ExtName\\' => 'Classes',
        ],
    ],
];
