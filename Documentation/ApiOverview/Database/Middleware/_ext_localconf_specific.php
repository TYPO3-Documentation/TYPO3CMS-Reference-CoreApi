<?php

declare(strict_types=1);

use MyVendor\MyExtension\Doctrine\Driver\MyDriverMiddleware;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['driverMiddlewares']['driver-middleware-identifier'] = [
    'target' => MyDriverMiddleware::class,
    'after' => [
        'typo3/core/custom-platform-driver-middleware',
    ],
];
