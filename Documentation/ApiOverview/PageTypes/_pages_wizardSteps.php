<?php

defined('TYPO3') or die();

$GLOBALS['TCA']['pages']['types']['116']['wizardSteps'] = [
    'setup' => [
        'title' => 'examples.messages:wizard.step.setup',
        'fields' => ['title', 'slug', 'nav_title', 'hidden', 'nav_hide'],
    ],
    'archive' => [
        'title' => 'examples.messages:wizard.step.archive',
        'fields' => ['tx_examples_archived_date'],
        'after' => ['setup'],
    ],
];
