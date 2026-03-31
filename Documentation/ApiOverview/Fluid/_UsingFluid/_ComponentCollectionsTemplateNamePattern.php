<?php

return [
    'MyVendor\\MyExtension\\Components' => [
        'templatePaths' => [
            10 => 'EXT:my_extension/Resources/Private/Components',
        ],
        'templateNamePattern' => '{path}/{name}',
        'additionalArgumentsAllowed' => true,
    ],
];
