<?php

declare(strict_types=1);

use MyVendor\MyExtension\Controller\MyModuleController;

return [
    'web_ExtkeyExample' => [
        //...
        'path' => '/module/web/ExtkeyExample',
        'controllerActions' => [
            MyModuleController::class => [
                'list',
                'detail',
            ],
        ],
    ],
];
