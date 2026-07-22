<?php

return [
    'columns' => [
        // ...

        'importance' => [
            'label' => 'Importance',
            'config' => [
                'type' => 'number',
                'default' => 0,
            ],
        ],

        'status' => [
            'label' => 'Status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['label' => 'None', 'value' => 0],
                    ['label' => 'Low', 'value' => 1],
                    ['label' => 'Medium', 'value' => 2],
                    ['label' => 'High', 'value' => 3],
                ],
                'default' => 0,
            ],
        ],

        // ...
    ],
];
