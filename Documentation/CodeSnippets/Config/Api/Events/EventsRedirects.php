<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => TYPO3\CMS\Redirects\Event\RedirectWasHitEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Redirects/RedirectWasHitEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => TYPO3\CMS\Redirects\Event\SlugRedirectChangeItemCreatedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Redirects/SlugRedirectChangeItemCreatedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => TYPO3\CMS\Redirects\Event\AfterAutoCreateRedirectHasBeenPersistedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Redirects/AfterAutoCreateRedirectHasBeenPersistedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => TYPO3\CMS\Redirects\Event\ModifyAutoCreateRedirectRecordBeforePersistingEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Redirects/ModifyAutoCreateRedirectRecordBeforePersistingEvent.rst.txt',
        'withCode' => false,
    ],
];
