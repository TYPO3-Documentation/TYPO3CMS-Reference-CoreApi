<?php

declare(strict_types=1);

use MyVendor\MyExtension\Database\Query\Restriction\CustomRestriction;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['DB']['additionalQueryRestrictions'][CustomRestriction::class] ??= [];
