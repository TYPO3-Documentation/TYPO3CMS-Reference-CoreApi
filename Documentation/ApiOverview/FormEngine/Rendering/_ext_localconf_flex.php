<?php

declare(strict_types=1);

use MyVendor\MyExtension\Form\Container\FlexFormEntryContainer;

defined('TYPO3') or die();

// Default registration of "flex" in NodeFactory:
// 'flex' => \TYPO3\CMS\Backend\Form\Container\FlexFormEntryContainer::class,

// Register language-aware FlexForm handling in FormEngine
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1443361297] = [
  'nodeName' => 'flex',
  'priority' => 40,
  'class' => FlexFormEntryContainer::class,
];
