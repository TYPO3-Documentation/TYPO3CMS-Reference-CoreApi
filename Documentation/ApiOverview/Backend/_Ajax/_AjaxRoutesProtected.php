<?php

use MyVendor\MyExtension\Controller\ExampleController;

return [
    'myextension_example_dosomething' => [
        'path' => '/my-extension/example/do-something',
        'target' => ExampleController::class . '::doSomethingAction',
        'inheritAccessFromModule' => 'my_module',
    ],
];
