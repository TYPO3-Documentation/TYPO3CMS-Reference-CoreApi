<?php

declare(strict_types=1);

use T3docs\Examples\Controller\AdminModuleController;
use T3docs\Examples\Controller\ModuleController;

/**
 * Definitions for modules provided by EXT:examples
 */
return [
    // Example for a module registration with Extbase controller
    'web_examples' => [
        'parent' => 'web',
        'position' => ['after' => 'web_info'],
        'access' => 'user',
        'workspaces' => 'live',
        'path' => '/module/page/example',
        'labels' => 'LLL:EXT:examples/Resources/Private/Language/Module/locallang_mod.xlf',
        // Extbase-specific configuration telling the TYPO3 Core to bootstrap Extbase
        'extensionName' => 'Examples',
        'controllerActions' => [
            ModuleController::class => [
                'flash', 'tree', 'clipboard', 'links', 'fileReference', 'fileReferenceCreate',
            ],
        ],
    ],
    // non-Extbase module registration
    'admin_examples' => [
        'parent' => 'system',
        'position' => ['top'],
        'access' => 'user',
        'workspaces' => 'live',
        'path' => '/module/system/example',
        'labels' => 'LLL:EXT:examples/Resources/Private/Language/AdminModule/locallang_mod.xlf',
        // non-Extbase modules are route-based, provide them
        'routes' => [
            '_default' => [
                'target' => AdminModuleController::class . '::manage',
            ],
            'edit' => [
                'path' => '/edit-me',
                'target' => AdminModuleController::class . '::edit',
            ],
        ],
    ],
];
