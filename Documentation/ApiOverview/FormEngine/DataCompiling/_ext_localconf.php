<?php

declare(strict_types=1);

use GeorgRinger\News\Backend\FormDataProvider\NewsFlexFormManipulation;
use TYPO3\CMS\Backend\Form\FormDataProvider\TcaFlexPrepare;
use TYPO3\CMS\Backend\Form\FormDataProvider\TcaFlexProcess;

defined('TYPO3') or die();

// Inject a data provider between TcaFlexPrepare and TcaFlexProcess
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['formDataGroup']['tcaDatabaseRecord'][NewsFlexFormManipulation::class] = [
    'depends' => [
        TcaFlexPrepare::class,
    ],
    'before' => [
        TcaFlexProcess::class,
    ],
];
