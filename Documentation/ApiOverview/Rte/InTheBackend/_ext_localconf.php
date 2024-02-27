<?php

declare(strict_types=1);

use MyVendor\MyExtension\Form\Resolver\RichTextNodeResolver;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeResolver'][1593194137] = [
    'nodeName' => 'text',
    'priority' => 50, // rte_ckeditor uses priority 50
    'class' => RichTextNodeResolver::class,
];
