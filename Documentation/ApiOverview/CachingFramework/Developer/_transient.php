<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend;

defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']
    ??= [];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['myext_mycache']['backend']
    ??= TransientMemoryBackend::class;
