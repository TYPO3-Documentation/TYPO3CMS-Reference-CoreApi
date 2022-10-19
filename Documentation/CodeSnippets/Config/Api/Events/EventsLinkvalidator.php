<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Linkvalidator\Event\BeforeRecordIsAnalyzedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Linkvalidator/BeforeRecordIsAnalyzedEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Linkvalidator\Event\ModifyValidatorTaskEmailEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Linkvalidator/ModifyValidatorTaskEmailEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\EventListener\LinkValidator\CheckExternalLinksToLocalPagesEventListener::class,
        'members' => [
            'LOCAL_DOMAIN',
            'TABLE_NAME',
            'FIELD_NAME',
            '__invoke'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'CodeSnippets/Events/Linkvalidator/BeforeRecordIsAnalyzedEvent/ExampleInvoke.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\EventListener\LinkValidator\CheckExternalLinksToLocalPagesEventListener::class,
        'members' => [
            'brokenLinkRepository',
            'softReferenceParserFactory',
            '__construct'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'CodeSnippets/Events/Linkvalidator/BeforeRecordIsAnalyzedEvent/ExampleInject.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\EventListener\LinkValidator\CheckExternalLinksToLocalPagesEventListener::class,
        'members' => [
            'LOCAL_DOMAIN',
            'TABLE_NAME',
            'FIELD_NAME',
            'softReferenceParserFactory',
            'parseField',
            'findAllParsers'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'CodeSnippets/Events/Linkvalidator/BeforeRecordIsAnalyzedEvent/ParseFields.rst.txt',
    ],
    [
        'action' => 'createPhpClassCodeSnippet',
        'class' => \T3docs\Examples\EventListener\LinkValidator\CheckExternalLinksToLocalPagesEventListener::class,
        'members' => [
            'LOCAL_DOMAIN',
            'TABLE_NAME',
            'FIELD_NAME',
            'brokenLinkRepository',
            'matchUrl',
            'addItemToBrokenLinkRepository'
        ],
        'withComment' => true,
        'withClassComment' => false,
        'targetFileName' => 'CodeSnippets/Events/Linkvalidator/BeforeRecordIsAnalyzedEvent/AddToBrokenLinkRepository.rst.txt',
    ],
];