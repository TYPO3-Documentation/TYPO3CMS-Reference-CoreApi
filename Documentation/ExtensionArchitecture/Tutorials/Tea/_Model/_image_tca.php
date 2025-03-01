<?php

return [
    // ...
    'columns' => [
        'image' => [
            'label' => 'LLL:EXT:tea/Resources/Private/Language/locallang_db.xlf:tx_tea_domain_model_tea.image',
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
];
