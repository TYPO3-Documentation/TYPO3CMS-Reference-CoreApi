<?php

declare(strict_types=1);

defined('TYPO3') or die();
// Override a file in the default language

$GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides']
    ['EXT:frontend/Resources/Private/Language/locallang_tca.xlf'][]
        = 'EXT:examples/Resources/Private/Language/custom.xlf';
// Override a Spanish ("es") translation
$GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides']['es']
    ['EXT:frontend/Resources/Private/Language/db/tt_content.xlf'][]
        = 'EXT:examples/Resources/Private/Language/Overrides/es.tt_content.xlf';
// The translation domain can be used as key instead of the file path
$GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides']['core.common'][]
    = 'EXT:examples/Resources/Private/Language/custom.xlf';
