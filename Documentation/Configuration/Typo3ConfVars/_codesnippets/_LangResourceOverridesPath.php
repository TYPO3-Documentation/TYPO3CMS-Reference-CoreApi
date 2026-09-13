<?php

$GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides']
    ['EXT:frontend/Resources/Private/Language/locallang_tca.xlf'][]
        = 'EXT:examples/Resources/Private/Language/custom.xlf';
// Override a German ("de") translation
$GLOBALS['TYPO3_CONF_VARS']['LANG']['resourceOverrides']['de']
    ['EXT:news/Resources/Private/Language/locallang_modadministration.xlf'][]
        = 'EXT:examples/Resources/Private/Language/Overrides/'
            . 'de.locallang_modadministration.xlf';
