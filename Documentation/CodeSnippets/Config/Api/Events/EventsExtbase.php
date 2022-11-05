<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extbase\Event\Mvc\AfterRequestDispatchedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Extbase/AfterRequestDispatchedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extbase\Event\Mvc\BeforeActionCallEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Extbase/BeforeActionCallEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extbase\Event\Persistence\AfterObjectThawedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Extbase/AfterObjectThawedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extbase\Event\Persistence\EntityAddedToPersistenceEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Extbase/EntityAddedToPersistenceEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extbase\Event\Persistence\EntityPersistedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Extbase/EntityPersistedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extbase\Event\Persistence\EntityRemovedFromPersistenceEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Extbase/EntityRemovedFromPersistenceEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extbase\Event\Persistence\EntityUpdatedInPersistenceEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Extbase/EntityUpdatedInPersistenceEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extbase\Event\Persistence\ModifyQueryBeforeFetchingObjectDataEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Extbase/ModifyQueryBeforeFetchingObjectDataEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extbase\Event\Persistence\ModifyResultAfterFetchingObjectDataEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Extbase/ModifyResultAfterFetchingObjectDataEvent.rst.txt',
        'withCode' => false,
    ],
];
