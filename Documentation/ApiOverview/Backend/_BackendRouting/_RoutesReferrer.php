<?php

use MyVendor\MyExtension\Controller\MyRouteController;

return [
  'my_route' => [
    'path' => '/my-route/{identifier}',
    'referrer' => 'required,refresh-empty',
    'target' => MyRouteController::class . '::handle',
  ],
];
