<?php

use TYPO3\CMS\Backend\Controller;

return [
    // Login screen of the TYPO3 Backend
    'login' => [
        'path' => '/login',
        'access' => 'public',
        'target' => Controller\LoginController::class . '::formAction',
    ],

    // Main backend rendering setup (previously called backend.php) for the TYPO3 Backend
    'main' => [
        'path' => '/main',
        'referrer' => 'required,refresh-always',
        'target' => Controller\BackendController::class . '::mainAction',
    ],

    // ...
];
