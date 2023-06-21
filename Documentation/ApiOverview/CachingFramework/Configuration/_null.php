<?php

use TYPO3\CMS\Core\Cache\Backend\NullBackend;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']
    ['extbase_reflection']['backend'] = NullBackend::class;
