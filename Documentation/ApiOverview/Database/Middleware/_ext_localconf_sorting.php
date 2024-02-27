<?php

declare(strict_types=1);

use MyVendor\MyExtension\Doctrine\Driver\CustomGlobalDriverMiddleware;

defined('TYPO3') or die();

// Register global driver middleware
$GLOBALS['TYPO3_CONF_VARS']['DB']['globalDriverMiddlewares']['global-driver-middleware-identifier'] = [
    'target' => CustomGlobalDriverMiddleware::class,
    'disabled' => false,
    'after' => [
        // NOTE: Custom driver middleware should be registered after essential
        //       TYPO3 Core driver middlewares. Use the following identifiers
        //       to ensure that.
        'typo3/core/custom-platform-driver-middleware',
        'typo3/core/custom-pdo-driver-result-middleware',
    ],
    'before' => [
        'some-driver-middleware-identifier',
    ],
];

// Disable a global driver middleware for a connection
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['SecondDatabase']['driverMiddlewares']['global-driver-middleware-identifier'] = [
    // To disable a global driver middleware, setting disabled to true for a
    // connection is enough. Repeating target, after and/or before configuration
    // is not required.
    'disabled' => true,
];
