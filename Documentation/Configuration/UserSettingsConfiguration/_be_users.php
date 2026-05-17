<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

ExtensionManagementUtility::addUserSetting(
    'mobile',
    [
        'label' => 'LLL:examples.db:be_users.tx_examples_mobile',
        'config' => [
            'type' => 'input',
        ],
    ],
    'after:email',
);
