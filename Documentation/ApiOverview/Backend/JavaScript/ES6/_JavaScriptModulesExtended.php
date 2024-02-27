<?php

return [
    'dependencies' => ['core', 'backend'],
    'imports' => [
        '@vendor/my-extension/' => [
            'path' => 'EXT:my_extension/Resources/Public/JavaScript/',
            // Exclude files of the following folders from being import-mapped
            'exclude' => [
                'EXT:my_extension/Resources/Public/JavaScript/Contrib/',
                'EXT:my_extension/Resources/Public/JavaScript/Overrides/',
            ],
        ],
        // Adding a third party package
        'thirdpartypkg' => 'EXT:my_extension/Resources/Public/JavaScript/Contrib/thidpartypkg/index.js',
        'thidpartypkg/' => 'EXT:my_extension/Resources/Public/JavaScript/Contrib/thirdpartypkg/',
        // Overriding a file from another package
        '@typo3/backend/modal.js' => 'EXT:my_extension/Resources/Public/JavaScript/Overrides/BackendModal.js',
    ],
];
