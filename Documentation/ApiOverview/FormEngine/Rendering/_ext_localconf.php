<?php

declare(strict_types=1);

use MyVendor\CoolTagCloud\Form\Element\SelectTagCloudElement;

defined('TYPO3') or die();

// Add new field type to NodeFactory
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1487112284] = [
    'nodeName' => 'selectTagCloud',
    'priority' => '70',
    'class' => SelectTagCloudElement::class,
];
