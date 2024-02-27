<?php

declare(strict_types=1);

use MyVendor\MyExtension\Domain\Model\MyExtendedModel;
use OriginalVendor\OriginalExtension\Domain\Model\SomeModel;

defined('TYPO3') or die('Access denied.');

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][SomeModel::class] = [
    'className' => MyExtendedModel::class,
];
