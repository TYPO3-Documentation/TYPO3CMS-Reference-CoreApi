<?php
return [
    // ...
    'columns' => [
        'title' => [
            'label' => 'Title',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim,required',
            ],
        ],
        'subtitle' => [
            'label' => 'Subtitle',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'nullable' => true,
            ],
        ],
        'description' => [
            'label' => 'Description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 5,
            ],
        ],
        'icon' => [
            'label' => 'Icon',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'maxitems' => 1,
                'items' => [
                    [
                        'label' => 'Font Awesome Icons',
                        'value' => '--div--',
                    ],
                    [
                        'label' => 'Star',
                        'value' => 'fa-solid fa-star',
                    ],
                    [
                        'label' => 'Heart',
                        'value' => 'fa-solid fa-heart',
                    ],
                    [
                        'label' => 'Comment',
                        'value' => 'fa-solid fa-comment',
                    ],
                ],
                'default' => 'fa-solid fa-star',
            ],
        ],
        'color' => [
            'label' => 'Color',
            'config' => [
                'type' => 'color',
            ],
        ],
        'email' => [
            'label' => 'Email',
            'config' => [
                'type' => 'email',
            ],
        ],
        'password' => [
            'label' => 'Password',
            'config' => [
                'type' => 'password',
            ],
        ],
        'virtualValue' => [
            'label' => 'Virtual Value',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
