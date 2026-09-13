<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\IndexedSearch\Event\BeforeFinalSearchQueryIsExecutedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/IndexedSearch/BeforeFinalSearchQueryIsExecutedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\IndexedSearch\Event\AfterSearchResultSetsAreGeneratedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/IndexedSearch/AfterSearchResultSetsAreGeneratedEvent.rst.txt',
        'withCode' => false,
    ],
];
