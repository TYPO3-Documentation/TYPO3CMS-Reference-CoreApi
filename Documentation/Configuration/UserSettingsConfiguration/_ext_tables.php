<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

$lll = 'LLL:EXT:examples/Resources/Private/Language/locallang_db.xlf:';

$GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_examples_mobile'] = [
    'label' => $lll . 'be_users.tx_examples_mobile',
    'type' => 'text',
    'table' => 'be_users',
];
ExtensionManagementUtility::addFieldsToUserSettings(
    $lll . 'be_users.tx_examples_mobile,tx_examples_mobile',
    'after:email',
);
