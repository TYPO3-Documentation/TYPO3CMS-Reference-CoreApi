<?php

return [
    'ctrl' => [
        'title' => 'Paper',
        'label' => 'title',
        'delete' => 'deleted',
    ],
    'columns' => [
        'title' => [
            'label' => 'Title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'author' => [
            'label' => 'Author',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => 'title, author',
        ],
    ],
];
