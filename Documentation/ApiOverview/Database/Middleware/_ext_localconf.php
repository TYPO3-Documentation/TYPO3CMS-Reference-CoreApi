<?php

declare(strict_types=1);

use MyVendor\MyExtension\Database\Log\MyMiddleware;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['driverMiddlewares']['myextension_mymiddleware']
    = MyMiddleware::class;
