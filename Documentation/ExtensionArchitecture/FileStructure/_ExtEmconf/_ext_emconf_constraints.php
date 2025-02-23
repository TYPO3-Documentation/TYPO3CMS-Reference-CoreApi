<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Extension title',
    // ...
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
            'php' => '8.1.0-8.3.99',
        ],
        'conflicts' => [
            'tt_news' => '',
        ],
        'suggests' => [
            'news' => '11.0.0-11.99.99',
        ],
    ],
];
