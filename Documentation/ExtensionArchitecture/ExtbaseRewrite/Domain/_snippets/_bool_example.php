<?php

return [
    'columns' => [
        'wants_newsletter' => [
            'label' => 'Subscribe to newsletter',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
            ],
        ],
        'accepted_privacy_policy' => [
            'label' => 'I accept the privacy policy',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
    ],
];
