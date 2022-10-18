<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Backend\Controller\Event\AfterFormEnginePageInitializedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Backend/AfterFormEnginePageInitializedEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Backend\History\Event\AfterHistoryRollbackFinishedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Backend/AfterHistoryRollbackFinishedEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Backend\Controller\Event\AfterPageColumnsSelectedForLocalizationEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Backend/AfterPageColumnsSelectedForLocalizationEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Backend\Controller\Event\BeforeFormEnginePageInitializedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Backend/BeforeFormEnginePageInitializedEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Backend\History\Event\BeforeHistoryRollbackStartEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Backend/BeforeHistoryRollbackStartEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Backend\Backend\Event\ModifyClearCacheActionsEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Backend/ModifyClearCacheActionsEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Backend\LoginProvider\Event\ModifyPageLayoutOnLoginProviderSelectionEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Backend/ModifyPageLayoutOnLoginProviderSelectionEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Backend\Authentication\Event\SwitchUserEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Backend/SwitchUserEvent.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Backend\Backend\Event\SystemInformationToolbarCollectorEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Backend/SystemInformationToolbarCollectorEvent.rst.txt',
        'withCode' => false
    ],
];