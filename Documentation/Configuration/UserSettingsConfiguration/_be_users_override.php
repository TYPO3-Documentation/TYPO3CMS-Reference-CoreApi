<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

ExtensionManagementUtility::addUserSetting(
    'myCustomSetting',
    [
        'label' => 'LLL:EXT:my_ext/Resources/Private/Language/locallang.xlf:myCustomSetting',
        'config' => [
            'type' => 'check',
            'renderType' => 'checkboxToggle',
        ],
    ],
    'after:emailMeAtLogin',
);
