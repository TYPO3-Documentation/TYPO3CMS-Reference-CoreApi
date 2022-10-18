<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\FrontendLogin\Event\BeforeRedirectEvent::class,
        'targetFileName' => 'CodeSnippets/Events/FrontendLogin/BeforeRedirectEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\FrontendLogin\Event\LoginConfirmedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/FrontendLogin/LoginConfirmedEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\FrontendLogin\Event\LoginErrorOccurredEvent::class,
        'targetFileName' => 'CodeSnippets/Events/FrontendLogin/LoginErrorOccurredEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\FrontendLogin\Event\LogoutConfirmedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/FrontendLogin/LogoutConfirmedEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\FrontendLogin\Event\ModifyLoginFormViewEvent::class,
        'targetFileName' => 'CodeSnippets/Events/FrontendLogin/ModifyLoginFormViewEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\FrontendLogin\Event\PasswordChangeEvent::class,
        'targetFileName' => 'CodeSnippets/Events/FrontendLogin/PasswordChangeEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\FrontendLogin\Event\SendRecoveryEmailEvent::class,
        'targetFileName' => 'CodeSnippets/Events/FrontendLogin/SendRecoveryEmailEvent.rst.txt',
        'withCode' => false
    ],
];
