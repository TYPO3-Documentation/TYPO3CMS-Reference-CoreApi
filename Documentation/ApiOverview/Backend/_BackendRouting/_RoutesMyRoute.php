<?php

use MyVendor\MyExtension\Controller\MyRouteController;

return [
    'my_route' => [
        'path' => '/my-route/{identifier}',
        'target' => MyRouteController::class . '::handle',
    ],
];
