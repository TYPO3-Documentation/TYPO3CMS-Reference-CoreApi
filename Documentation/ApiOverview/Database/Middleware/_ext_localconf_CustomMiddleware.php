<?php

declare(strict_types=1);

use MyVendor\MyExtension\DoctrineDBAL\CustomMiddleware;

defined('TYPO3') or die();

// Register middleware globally, to include it for all connections which
// uses the 'pdo_sqlite' driver.
$GLOBALS['TYPO3_CONF_VARS']['DB']['globalDriverMiddlewares']['my-ext/custom-pdosqlite-driver-middleware'] = [
    'target' => CustomMiddleware::class,
    'after' => [
        // NOTE: Custom driver middleware should be registered after essential
        //       TYPO3 Core driver middlewares. Use the following identifiers
        //       to ensure that.
        'typo3/core/custom-platform-driver-middleware',
        'typo3/core/custom-pdo-driver-result-middleware',
    ],
];
