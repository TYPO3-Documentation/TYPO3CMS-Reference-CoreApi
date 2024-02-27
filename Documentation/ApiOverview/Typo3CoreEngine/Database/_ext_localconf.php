<?php

declare(strict_types=1);

use Vendor\SomeExtension\Hook\DataHandlerHook;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] =
    DataHandlerHook::class . '->postProcessClearCache';
