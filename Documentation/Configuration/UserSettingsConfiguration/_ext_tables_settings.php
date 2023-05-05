<?php

declare(strict_types=1);

defined('TYPO3') or die();

$GLOBALS['TYPO3_USER_SETTINGS'] = [
    'columns' => [
        'customButton' => [
            'type' => 'button',
            'clickData' => [
                'eventName' => 'setup:customButton:clicked',
            ],
            'confirm' => true,
            'confirmData' => [
                'message' => 'Please confirm...',
                'eventName' => 'setup:customButton:confirmed',
            ],
        ],
        // ...
    ],
];
