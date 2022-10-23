<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Workspaces\Event\AfterCompiledCacheableDataForWorkspaceEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Workspaces/AfterCompiledCacheableDataForWorkspaceEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Workspaces\Event\AfterDataGeneratedForWorkspaceEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Workspaces/AfterDataGeneratedForWorkspaceEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Workspaces\Event\GetVersionedDataEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Workspaces/GetVersionedDataEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Workspaces\Event\ModifyVersionDifferencesEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Workspaces/ModifyVersionDifferencesEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Workspaces\Event\SortVersionedDataEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Workspaces/SortVersionedDataEvent.rst.txt',
        'withCode' => false,
    ],
];
