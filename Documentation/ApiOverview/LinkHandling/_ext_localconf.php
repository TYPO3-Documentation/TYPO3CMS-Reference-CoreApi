<?php

declare(strict_types=1);

use MyVendor\MyExtension\LinkHandler\MyLinkBuilder;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['FE']['typolinkBuilder']['mylinkkey'] =
    MyLinkBuilder::class;
