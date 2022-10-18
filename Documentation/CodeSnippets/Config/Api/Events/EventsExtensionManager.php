<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extensionmanager\Event\AfterExtensionDatabaseContentHasBeenImportedEvent::class,
        'targetFileName' => 'Events/ExtensionManager/AfterExtensionDatabaseContentHasBeenImportedEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extensionmanager\Event\AfterExtensionFilesHaveBeenImportedEvent::class,
        'targetFileName' => 'Events/ExtensionManager/AfterExtensionFilesHaveBeenImportedEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extensionmanager\Event\AfterExtensionStaticDatabaseContentHasBeenImportedEvent::class,
        'targetFileName' => 'Events/ExtensionManager/AfterExtensionStaticDatabaseContentHasBeenImportedEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extensionmanager\Event\AvailableActionsForExtensionEvent::class,
        'targetFileName' => 'Events/ExtensionManager/AvailableActionsForExtensionEvent.rst.txt',
        'withCode' => false
    ]
];