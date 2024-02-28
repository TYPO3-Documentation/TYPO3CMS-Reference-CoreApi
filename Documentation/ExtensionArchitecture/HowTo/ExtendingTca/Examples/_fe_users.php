<?php

declare(strict_types=1);

call_user_func(static function () {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'fe_users',
        'tx_myextension_options, tx_myextension_special',
        '',
        'after:password',
    );
});
