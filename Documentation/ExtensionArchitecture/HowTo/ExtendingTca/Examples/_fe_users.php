<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addToAllTCAtypes(
    'fe_users',
    'tx_myextension_options, tx_myextension_special',
    '',
    'after:password',
);
