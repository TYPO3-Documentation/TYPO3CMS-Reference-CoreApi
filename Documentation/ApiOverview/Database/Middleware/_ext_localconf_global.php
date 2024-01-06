<?php

declare(strict_types=1);

use MyVendor\MyExtension\Doctrine\Driver\CustomGlobalDriverMiddleware;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['DB']['globalDriverMiddlewares']['my-ext/custom-global-driver-middleware'] = [
    'target' => CustomGlobalDriverMiddleware::class,
    'after' => [
        'typo3/core/custom-platform-driver-middleware',
    ],
];
