<?php

declare(strict_types=1);

use T3docs\Examples\Controller\AdminModuleController;
use T3docs\Examples\Controller\ModuleController;

/**
 * Definitions for modules provided by EXT:examples
 */
return [
    'web_examples' => [
        'parent' => 'web',
        'position' => ['after' => 'web_info'],
        'access' => 'user',
        'workspaces' => 'live',
        'path' => '/module/page/example',
        'labels' => 'LLL:EXT:examples/Resources/Private/Language/Module/locallang_mod.xlf',
        'extensionName' => 'Examples',
        'controllerActions' => [
            ModuleController::class => [
                'flash', 'tree', 'clipboard', 'links', 'fileReference', 'fileReferenceCreate',
            ],
        ],
    ],
    'admin_examples' => [
        'parent' => 'system',
        'position' => ['top'],
        'access' => 'user',
        'workspaces' => 'live',
        'path' => '/module/system/example',
        'labels' => 'LLL:EXT:examples/Resources/Private/Language/AdminModule/locallang_mod.xlf',
        'controllerActions' => [
            AdminModuleController::class => [
                'index',
            ],
        ],
    ],
];
