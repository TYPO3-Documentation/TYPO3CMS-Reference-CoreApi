<?php

declare(strict_types=1);

use MyVendor\MyExtension\Routing\CustomEnhancer;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['routing']['enhancers']['CustomEnhancer']
    = CustomEnhancer::class;
