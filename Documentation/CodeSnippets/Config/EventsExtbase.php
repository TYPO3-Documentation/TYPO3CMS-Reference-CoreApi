<?php

return [
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Extbase\Event\Mvc\AfterRequestDispatchedEvent::class,
        "targetFileName"=> "Events/Extbase/AfterRequestDispatchedEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Extbase\Event\Mvc\BeforeActionCallEvent::class,
        "targetFileName"=> "Events/Extbase/BeforeActionCallEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Extbase\Event\Persistence\AfterObjectThawedEvent::class,
        "targetFileName"=> "Events/Extbase/AfterObjectThawedEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Extbase\Event\Persistence\EntityAddedToPersistenceEvent::class,
        "targetFileName"=> "Events/Extbase/EntityAddedToPersistenceEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Extbase\Event\Persistence\EntityPersistedEvent::class,
        "targetFileName"=> "Events/Extbase/EntityPersistedEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Extbase\Event\Persistence\EntityRemovedFromPersistenceEvent::class,
        "targetFileName"=> "Events/Extbase/EntityRemovedFromPersistenceEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Extbase\Event\Persistence\EntityUpdatedInPersistenceEvent::class,
        "targetFileName"=> "Events/Extbase/EntityUpdatedInPersistenceEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Extbase\Event\Persistence\ModifyQueryBeforeFetchingObjectDataEvent::class,
        "targetFileName"=> "Events/Extbase/ModifyQueryBeforeFetchingObjectDataEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Extbase\Event\Persistence\ModifyResultAfterFetchingObjectDataEvent::class,
        "targetFileName"=> "Events/Extbase/ModifyResultAfterFetchingObjectDataEvent.rst.txt",
        "withCode"=> false
    ]
];