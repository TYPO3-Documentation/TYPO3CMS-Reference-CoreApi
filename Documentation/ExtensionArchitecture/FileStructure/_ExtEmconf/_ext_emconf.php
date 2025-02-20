<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Extension title',
    'description' => 'Extension description',
    'category' => 'plugin',
    'author' => 'John Doe',
    'author_email' => 'john.doe@example.org',
    'author_company' => 'some company',
    'state' => 'stable',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
];
