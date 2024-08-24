<?php

return [
    'frontend' => [
        'middleware-identifier' => [
            'disabled' => true,
        ],
        'overwrite-middleware-identifier' => [
            'target' => \MyVendor\SomeExtension\Middleware\MyMiddleware::class,
            'after' => [
                'another-middleware-identifier',
            ],
            'before' => [
                '3rd-middleware-identifier',
            ],
        ],
    ],
];
