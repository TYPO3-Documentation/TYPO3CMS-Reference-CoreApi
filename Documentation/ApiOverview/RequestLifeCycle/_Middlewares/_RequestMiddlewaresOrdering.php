<?php

return [
    'frontend' => [
        'middleware-identifier' => [
            'after' => [
                'another-middleware-identifier',
            ],
            'before' => [
                '3rd-middleware-identifier',
            ],
        ],
    ],
];
