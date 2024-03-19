<?php

declare(strict_types=1);

use MyVendor\MyExtension\Domain\Repository\MyExtendedRepository;
use OriginalVendor\OriginalExtension\Domain\Repository\SomeRepository;

defined('TYPO3') or die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][SomeRepository::class] = [
    'className' => MyExtendedRepository::class,
];
