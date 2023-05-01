<?php

declare(strict_types=1);

use MyVendor\MyExtension\ViewHelpers;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['myextension'] = [
    ViewHelpers::class,
];
