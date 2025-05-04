<?php

declare(strict_types=1);

use MyVendor\MyExtension\Doctrine\Driver\CustomGlobalDriverMiddleware;

defined('TYPO3') or die();

// Register a global middleware
$GLOBALS['TYPO3_CONF_VARS']['DB']['globalDriverMiddlewares']['my-ext/custom-global-driver-middleware'] = [
    'target' => CustomGlobalDriverMiddleware::class,
    'after' => [
        // NOTE: Custom driver middleware should be registered after essential
        //       TYPO3 Core driver middlewares. Use the following identifiers
        //       to ensure that.
        'typo3/core/custom-platform-driver-middleware',
        'typo3/core/custom-pdo-driver-result-middleware',
    ],
];

// Disable a global driver middleware for a specific connection
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['SecondDatabase']['driverMiddlewares']['my-ext/custom-global-driver-middleware']['disabled'] = true;
