<?php

declare(strict_types=1);

use MyVendor\MyExtension\Classes\Controller\MyModuleController;

return [
    'my_module' => [
        // ...
        'routes' => [
            '_default' => [
                'target' => MyModuleController::class . '::overview',
            ],
            'edit' => [
                'path' => '/edit-me',
                'target' => MyModuleController::class . '::edit',
            ],
            'manage' => [
                'target' => AnotherController::class . '::manage',
                'methods' => ['POST'],
            ],
        ],
    ],
];
