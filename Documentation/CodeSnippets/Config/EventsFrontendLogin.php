<?php

return [
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\FrontendLogin\Event\LoginConfirmedEvent::class,
        "targetFileName"=> "Events/FrontendLogin/LoginConfirmedEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\FrontendLogin\Event\ModifyLoginFormViewEvent::class,
        "targetFileName"=> "Events/FrontendLogin/ModifyLoginFormViewEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\FrontendLogin\Event\SendRecoveryEmailEvent::class,
        "targetFileName"=> "Events/FrontendLogin/SendRecoveryEmailEvent.rst.txt",
        "withCode"=> false
    ]
];