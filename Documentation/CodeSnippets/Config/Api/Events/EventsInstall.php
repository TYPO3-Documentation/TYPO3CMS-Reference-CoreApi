<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Install\Service\Event\ModifyLanguagePackRemoteBaseUrlEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Install/ModifyLanguagePackRemoteBaseUrlEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Install\Service\Event\ModifyLanguagePacksEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Install/ModifyLanguagePacksEvent.rst.txt',
        'withCode' => false,
    ],
];
