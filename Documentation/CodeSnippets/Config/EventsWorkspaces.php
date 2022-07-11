<?php

return [
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Workspaces\Event\AfterCompiledCacheableDataForWorkspaceEvent::class,
        "targetFileName"=> "Events/Workspaces/AfterCompiledCacheableDataForWorkspaceEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Workspaces\Event\AfterDataGeneratedForWorkspaceEvent::class,
        "targetFileName"=> "Events/Workspaces/AfterDataGeneratedForWorkspaceEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Workspaces\Event\GetVersionedDataEvent::class,
        "targetFileName"=> "Events/Workspaces/GetVersionedDataEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Workspaces\Event\SortVersionedDataEvent::class,
        "targetFileName"=> "Events/Workspaces/SortVersionedDataEvent.rst.txt",
        "withCode"=> false
    ]
];