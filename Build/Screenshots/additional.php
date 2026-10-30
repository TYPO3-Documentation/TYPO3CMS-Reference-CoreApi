<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Core\Environment;

// Copied to config/system/ by run.sh

// The custom language of the page about managing translations
$GLOBALS['TYPO3_CONF_VARS']['SYS']['localization']['locales']['user'] = [
    'gsw_CH' => 'Swiss German',
];
$GLOBALS['TYPO3_CONF_VARS']['SYS']['localization']['locales']['dependencies'] = [
    'gsw_CH' => ['de_AT', 'de'],
];

// A label of the content elements, overridden in Spanish
$GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides']['es']['frontend.db.tt_content'][]
    = Environment::getProjectPath() . '/Build/Screenshots/es.label-override.xlf';
