<?php

use MyVendor\MyExtension\Controller\Ajax\ImportDataController;

return [
    'something-import-data' => [
        'path' => '/something/import-data',
        'target' => ImportDataController::class . '::importDataAction',
    ],
];
