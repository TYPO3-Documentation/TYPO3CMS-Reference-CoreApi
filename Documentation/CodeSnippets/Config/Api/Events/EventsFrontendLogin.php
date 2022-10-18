<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\FrontendLogin\Event\BeforeRedirectEvent::class,
        'targetFileName' => 'Events/FrontendLogin/BeforeRedirectEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\FrontendLogin\Event\LoginConfirmedEvent::class,
        'targetFileName' => 'Events/FrontendLogin/LoginConfirmedEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\FrontendLogin\Event\LoginErrorOccurredEvent::class,
        'targetFileName' => 'Events/FrontendLogin/LoginErrorOccurredEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\FrontendLogin\Event\LogoutConfirmedEvent::class,
        'targetFileName' => 'Events/FrontendLogin/LogoutConfirmedEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\FrontendLogin\Event\ModifyLoginFormViewEvent::class,
        'targetFileName' => 'Events/FrontendLogin/ModifyLoginFormViewEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\FrontendLogin\Event\PasswordChangeEvent::class,
        'targetFileName' => 'Events/FrontendLogin/PasswordChangeEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\FrontendLogin\Event\SendRecoveryEmailEvent::class,
        'targetFileName' => 'Events/FrontendLogin/SendRecoveryEmailEvent.rst.txt',
        'withCode' => false
    ],
];
