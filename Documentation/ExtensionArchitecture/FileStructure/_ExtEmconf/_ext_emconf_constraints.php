<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Extension title',
    // ...
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
            'php' => '8.2.0-8.4.99',
        ],
        'conflicts' => [
            'tt_news' => '',
        ],
        'suggests' => [
            'news' => '12.1.0-12.99.99',
        ],
    ],
];
