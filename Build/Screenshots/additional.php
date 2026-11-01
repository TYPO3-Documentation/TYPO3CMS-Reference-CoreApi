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

// The exception page of the debug exception handler, only for the
// screenshot that asks for it, as the settings also change the preset that
// the Install Tool shows as active. The browser runs in a container of its
// own, so its address is no local one.
if (isset($_SERVER['HTTP_X_SCREENSHOT_DISPLAY_ERRORS'])) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['displayErrors'] = 1;
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'] = '*';
}
