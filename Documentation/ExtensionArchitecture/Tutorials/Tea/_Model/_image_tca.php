<?php

return [
    // ...
    'columns' => [
        'image' => [
            'label' => 'tea.db:tx_tea_domain_model_tea.image',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'appearance' => [
                    'collapseAll' => true,
                    'useSortable' => false,
                    'enabledControls' => [
                        'hide' => false,
                    ],
                ],
                'allowed' => 'common-image-types',
            ],
        ],
    ],
];
