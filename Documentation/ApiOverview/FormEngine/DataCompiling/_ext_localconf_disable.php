<?php

declare(strict_types=1);

use TYPO3\CMS\Backend\Form\FormDataProvider\TcaCheckboxItems;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']
    ['tcaDatabaseRecord'][TcaCheckboxItems::class]['disabled'] = true;
