<?php

return [
    'something-import-data' => [
        'path' => '/something/import-data',
        'target' => \MyVendor\MyExtension\Controller\Ajax\ImportDataController::class . '::importDataAction',
    ],
];
