<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Form\Mvc\Persistence\Event\AfterFormDefinitionLoadedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Form/AfterFormDefinitionLoadedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Form\Event\BeforeFormIsSavedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Form/BeforeFormIsSavedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Form\Event\BeforeFormIsCreatedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Form/BeforeFormIsCreatedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Form\Event\BeforeRenderableIsAddedToFormEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Form/BeforeRenderableIsAddedToFormEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Form\Event\BeforeFormIsDuplicatedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Form/BeforeFormIsDuplicatedEvent.rst.txt',
        'withCode' => false,
    ],
];
