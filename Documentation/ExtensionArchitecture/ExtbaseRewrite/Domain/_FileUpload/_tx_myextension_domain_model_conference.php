<?php

return [
    'ctrl' => [
        // ... table-specific ctrl fields
    ],
    'columns' => [
        // ... table-specific columns
        'logo' => [
            'exclude' => true,
            'label' => 'Logo',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'common-image-types',
            ],
        ],
        'impressions' => [
            'exclude' => true,
            'label' => 'Impressions',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
            ],
        ],
    ],
];
