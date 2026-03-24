<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Fluid\Event\ModifyComponentDefinitionEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Fluid/ModifyComponentDefinitionEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Fluid\Event\ModifyNamespacesEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Fluid/ModifyNamespacesEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Fluid\Event\ModifyRenderedContentAreaEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Fluid/ModifyRenderedContentAreaEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Fluid\Event\ModifyRenderedRecordEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Fluid/ModifyRenderedRecordEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Fluid\Event\ProvideStaticVariablesToComponentEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Fluid/ProvideStaticVariablesToComponentEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Fluid\Event\RenderComponentEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Fluid/RenderComponentEvent.rst.txt',
        'withCode' => false,
    ],
];
