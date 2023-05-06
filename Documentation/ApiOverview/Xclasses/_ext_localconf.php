<?php

declare(strict_types=1);

use MyVendor\MyExtension\Xclass\NewRecordController as NewRecordControllerXclass;
use TYPO3\CMS\Backend\Controller\NewRecordController;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][NewRecordController::class] = [
    'className' => NewRecordControllerXclass::class,
];
