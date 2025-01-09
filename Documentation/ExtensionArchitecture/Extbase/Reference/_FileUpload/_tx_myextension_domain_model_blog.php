<?php

return [
    'ctrl' => [
        // .. usual TCA fields
    ],
    'columns' => [
        // ... usual TCA columns
        'single_file' => [
            'exclude' => true,
            'label' => 'Single file',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'common-image-types',
            ],
        ],
        'multiple_files' => [
            'exclude' => true,
            'label' => 'Multiple files',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
            ],
        ],
    ],
];
