<?php

declare(strict_types=1);

return [
    // ...
    'columns' => [
        'datetime_text' => [
            'exclude' => true,
            'label' => 'type=datetime, db=text',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'datetime_int' => [
            'exclude' => true,
            'label' => 'type=datetime, db=int',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'datetime_datetime' => [
            'exclude' => true,
            'label' => 'type=datetime, db=datetime',
            'config' => [
                'type' => 'datetime',
                'dbType' => 'datetime',
                'nullable' => true,
            ],
        ],
    ],
];
