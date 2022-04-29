<?php

return [
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\Controller\Event\AfterFormEnginePageInitializedEvent::class,
        "targetFileName"=> "Events/Backend/AfterFormEnginePageInitializedEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\History\Event\AfterHistoryRollbackFinishedEvent::class,
        "targetFileName"=> "Events/Backend/AfterHistoryRollbackFinishedEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\Controller\Event\AfterPageColumnsSelectedForLocalizationEvent::class,
        "targetFileName"=> "Events/Backend/AfterPageColumnsSelectedForLocalizationEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\Controller\Event\BeforeFormEnginePageInitializedEvent::class,
        "targetFileName"=> "Events/Backend/BeforeFormEnginePageInitializedEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\History\Event\BeforeHistoryRollbackStartEvent::class,
        "targetFileName"=> "Events/Backend/BeforeHistoryRollbackStartEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\Backend\Event\ModifyClearCacheActionsEvent::class,
        "targetFileName"=> "Events/Backend/ModifyClearCacheActionsEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\LoginProvider\Event\ModifyPageLayoutOnLoginProviderSelectionEvent::class,
        "targetFileName"=> "Events/Backend/ModifyPageLayoutOnLoginProviderSelectionEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\Authentication\Event\SwitchUserEvent::class,
        "targetFileName"=> "Events/Backend/SwitchUserEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\Backend\Event\SystemInformationToolbarCollectorEvent::class,
        "targetFileName"=> "Events/Backend/SystemInformationToolbarCollectorEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\Search\Event\ModifyQueryForLiveSearchEvent::class,
        "targetFileName"=> "Events/Backend/ModifyQueryForLiveSearchEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\Controller\Event\ModifyPageLayoutContentEvent::class,
        "targetFileName"=> "Events/Backend/ModifyPageLayoutContentEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\Controller\Event\ModifyNewContentElementWizardItemsEvent::class,
        "targetFileName"=> "Events/Backend/ModifyNewContentElementWizardItemsEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\Form\Event\ModifyLinkExplanationEvent::class,
        "targetFileName"=> "Events/Backend/ModifyLinkExplanationEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\Form\Event\ModifyInlineElementEnabledControlsEvent::class,
        "targetFileName"=> "Events/Backend/ModifyInlineElementEnabledControlsEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\Form\Event\ModifyInlineElementControlsEvent::class,
        "targetFileName"=> "Events/Backend/ModifyInlineElementControlsEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\Form\Event\ModifyImageManipulationPreviewUrlEvent::class,
        "targetFileName"=> "Events/Backend/ModifyImageManipulationPreviewUrlEvent.rst.txt",
        "withCode"=> false
    ],
    // TYPO3 12.0
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Backend\Controller\Event\ModifyGenericBackendMessagesEvent::class,
        "targetFileName"=> "Events/Backend/ModifyGenericBackendMessagesEvent.rst.txt",
        "withCode"=> false
    ]
];