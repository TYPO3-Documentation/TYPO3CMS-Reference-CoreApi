<?php

declare(strict_types=1);

use MyVendor\MyExtension\DoctrineDBAL\CustomMiddleware;

defined('TYPO3') or die();

// Register middleware globally, to include it for all connections which
// uses the 'pdo_sqlite' driver.
$GLOBALS['TYPO3_CONF_VARS']['DB']['globalDriverMiddlewares']['my-ext/custom-pdosqlite-driver-middleware'] = [
    'target' => CustomMiddleware::class,
    'after' => [
        'typo3/core/custom-platform-driver-middleware',
    ],
];
