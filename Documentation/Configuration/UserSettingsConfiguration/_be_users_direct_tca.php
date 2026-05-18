<?php

declare(strict_types=1);

defined('TYPO3') or die();

// Add field configuration
$GLOBALS['TCA']['be_users']['columns']['user_settings']['columns']['myCustomSetting'] = [
    'label' => 'LLL:EXT:my_ext/Resources/Private/Language/locallang.xlf:myCustomSetting',
    'config' => [
        'type' => 'check',
        'renderType' => 'checkboxToggle',
    ],
];

// Add field to showitem
$GLOBALS['TCA']['be_users']['columns']['user_settings']['showitem'] .= ',myCustomSetting';
