<?php

declare(strict_types=1);

use MyVendor\MyExtension\FormEngine\FieldControl\ImportDataControl;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1485351217] = [
    'nodeName' => 'importDataControl',
    'priority' => 30,
    'class' => ImportDataControl::class,
];
