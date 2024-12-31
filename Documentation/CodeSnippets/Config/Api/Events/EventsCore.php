<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Authentication\Event\AfterGroupsResolvedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/AfterGroupsResolvedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Configuration\Event\AfterTcaCompilationEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/AfterTcaCompilationEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Configuration\Event\BeforeTcaOverridesEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BeforeTcaOverridesEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\TypoScript\IncludeTree\Event\ModifyLoadedPageTsConfigEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/ModifyLoadedPageTsConfigEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Core\Event\BootCompletedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BootCompletedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Database\Event\AlterTableDefinitionStatementsEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/AlterTableDefinitionStatementsEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\DataHandling\Event\AppendLinkHandlerElementsEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/AppendLinkHandlerElementsEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\DataHandling\Event\IsTableExcludedFromReferenceIndexEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/IsTableExcludedFromReferenceIndexEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Html\Event\BrokenLinkAnalysisEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BrokenLinkAnalysisEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Package\Event\AfterPackageActivationEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/AfterPackageActivationEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Package\Event\AfterPackageDeactivationEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/AfterPackageDeactivationEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Package\Event\BeforePackageActivationEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BeforePackageActivationEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Package\Event\PackagesMayHaveChangedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/PackagesMayHaveChangedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Page\Event\BeforeJavaScriptsRenderingEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BeforeJavaScriptsRenderingEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Page\Event\BeforeStylesheetsRenderingEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BeforeStylesheetsRenderingEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Tree\Event\ModifyTreeDataEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/ModifyTreeDataEvent.rst.txt',
        'withCode' => false,
    ],
    // TYPO3 v12.0
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Domain\Access\RecordAccessGrantedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/RecordAccessGrantedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Configuration\Event\SiteConfigurationBeforeWriteEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/SiteConfigurationBeforeWriteEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Configuration\Event\SiteConfigurationLoadedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/SiteConfigurationLoadedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Mail\Event\AfterMailerSentMessageEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/AfterMailerSentMessageEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Mail\Event\BeforeMailerSentMessageEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BeforeMailerSentMessageEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\TypoScript\AST\Event\EvaluateModifierFunctionEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/EvaluateModifierFunctionEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Domain\Event\BeforeRecordLanguageOverlayEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BeforeRecordLanguageOverlayEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Domain\Event\AfterRecordLanguageOverlayEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/AfterRecordLanguageOverlayEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Domain\Event\BeforePageLanguageOverlayEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BeforePageLanguageOverlayEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureIdentifierInitializedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/AfterFlexFormDataStructureIdentifierInitializedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureParsedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/AfterFlexFormDataStructureParsedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Configuration\Event\BeforeFlexFormDataStructureIdentifierInitializedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BeforeFlexFormDataStructureIdentifierInitializedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Configuration\Event\BeforeFlexFormDataStructureParsedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BeforeFlexFormDataStructureParsedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\TypoScript\IncludeTree\Event\AfterTemplatesHaveBeenDeterminedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/AfterTemplatesHaveBeenDeterminedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\TypoScript\IncludeTree\Event\BeforeLoadedPageTsConfigEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BeforeLoadedPageTsConfigEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\TypoScript\IncludeTree\Event\BeforeLoadedUserTsConfigEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BeforeLoadedUserTsConfigEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Authentication\Event\BeforeRequestTokenProcessedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BeforeRequestTokenProcessedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\PasswordPolicy\Event\EnrichPasswordValidationContextDataEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/PasswordPolicy/EnrichPasswordValidationContextDataEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Authentication\Event\BeforeUserLogoutEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BeforeUserLogoutEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Authentication\Event\AfterUserLoggedOutEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/AfterUserLoggedOutEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Authentication\Event\AfterUserLoggedInEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/AfterUserLoggedInEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Authentication\Event\AfterUserLoggedInEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/AfterUserLoggedInEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Authentication\Event\LoginAttemptFailedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/LoginAttemptFailedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Security\ContentSecurityPolicy\Event\PolicyMutatedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/Security/PolicyMutatedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Security\ContentSecurityPolicy\Event\InvestigateMutationsEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/Security/InvestigateMutationsEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Cache\Event\CacheFlushEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/Cache/CacheFlushEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Cache\Event\CacheWarmupEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/Cache/CacheWarmupEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Imaging\Event\ModifyRecordOverlayIconIdentifierEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/ModifyRecordOverlayIconIdentifierEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Domain\Event\ModifyDefaultConstraintsForDatabaseQueryEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/ModifyDefaultConstraintsForDatabaseQueryEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Domain\Event\BeforePageIsRetrievedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/BeforePageIsRetrievedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\LinkHandling\Event\BeforeTypoLinkEncodedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/LinkHandling/BeforeTypoLinkEncodedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\LinkHandling\Event\AfterTypoLinkDecodedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/LinkHandling/AfterTypoLinkDecodedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\LinkHandling\Event\AfterLinkResolvedByStringRepresentationEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/LinkHandling/AfterLinkResolvedByStringRepresentationEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Package\Event\PackageInitializationEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/Package/PackageInitializationEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Html\Event\BeforeTransformTextForPersistenceEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/Html/BeforeTransformTextForPersistenceEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Html\Event\AfterTransformTextForPersistenceEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/Html/AfterTransformTextForPersistenceEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Html\Event\BeforeTransformTextForRichTextEditorEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/Html/BeforeTransformTextForRichTextEditorEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Html\Event\AfterTransformTextForRichTextEditorEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/Html/AfterTransformTextForRichTextEditorEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Country\Event\BeforeCountriesEvaluatedEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/Country/BeforeCountriesEvaluatedEvent.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Domain\Event\RecordCreationEvent::class,
        'targetFileName' => 'CodeSnippets/Events/Core/RecordCreationEvent.rst.txt',
        'withCode' => false,
    ],
];
