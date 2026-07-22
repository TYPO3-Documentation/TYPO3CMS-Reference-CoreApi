<?php

use MyVendor\MyExtension\Enum\Status;

return [
    // ...
    'columns' => [
        'status' => [
            'label' => 'Status',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'maxitems' => 1,
                'items' => [
                    [
                        'label' => Status::DRAFT->getLabel(),
                        'value' => Status::DRAFT->name,
                    ],
                    [
                        'label' => Status::IN_REVIEW->getLabel(),
                        'value' => Status::IN_REVIEW->name,
                    ],
                    [
                        'label' => Status::PUBLISHED->getLabel(),
                        'value' => Status::PUBLISHED->name,
                    ],
                ],
                'default' => Status::DRAFT->name,
            ],
        ],
    ],
];
