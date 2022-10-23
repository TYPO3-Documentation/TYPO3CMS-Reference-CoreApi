<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extensionmanager\Event\AfterExtensionDatabaseContentHasBeenImportedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/ExtensionManager/AfterExtensionDatabaseContentHasBeenImportedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extensionmanager\Event\AfterExtensionFilesHaveBeenImportedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/ExtensionManager/AfterExtensionFilesHaveBeenImportedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extensionmanager\Event\AfterExtensionStaticDatabaseContentHasBeenImportedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/ExtensionManager/AfterExtensionStaticDatabaseContentHasBeenImportedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extensionmanager\Event\AvailableActionsForExtensionEvent::class,
        'targetFileName' => 'CodeSnippets/Events/ExtensionManager/AvailableActionsForExtensionEvent.rst.txt',
        'withCode' => false,
    ],
];
