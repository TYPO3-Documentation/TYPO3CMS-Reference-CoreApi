<?php

declare(strict_types=1);

use MyVendor\MyExtension\Database\Query\Restriction\CustomRestriction;

defined('TYPO3') or die();

if (!isset($GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions'][CustomRestriction::class])) {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions'][CustomRestriction::class] = [];
}
