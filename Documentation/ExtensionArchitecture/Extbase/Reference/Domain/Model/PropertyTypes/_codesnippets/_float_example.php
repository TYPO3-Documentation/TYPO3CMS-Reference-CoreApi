<?php
return [
    // ...
    'columns' => [
        'price' => [
            'label' => 'Price',
            'config' => [
                'type' => 'number',
                'format' => 'decimal',
                'default' => 0.0,
            ],
        ],
        'rating' => [
            'label' => 'Rating',
            'config' => [
                'type' => 'passtrough',
                'format' => 'decimal',
                'nullable' => true,
            ],
        ],
    ],
];
