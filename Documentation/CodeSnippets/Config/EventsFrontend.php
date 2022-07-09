<?php

return [
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Frontend\Event\ModifyHrefLangTagsEvent::class,
        "targetFileName"=> "Events/Frontend/ModifyHrefLangTagsEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Frontend\Event\ModifyPageLinkConfigurationEvent::class,
        "targetFileName"=> "Events/Frontend/ModifyPageLinkConfigurationEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Frontend\Event\FilterMenuItemsEvent::class,
        "targetFileName"=> "Events/Frontend/FilterMenuItemsEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Frontend\Authentication\ModifyResolvedFrontendGroupsEvent::class,
        "targetFileName"=> "Events/Frontend/ModifyResolvedFrontendGroupsEvent.rst.txt",
        "withCode"=> false
    ],
    // TYPO3 12.0
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Frontend\Event\ModifyCacheLifetimeForPageEvent::class,
        "targetFileName"=> "Events/Frontend/ModifyCacheLifetimeForPageEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Frontend\Event\ShouldUseCachedPageDataIfAvailableEvent::class,
        "targetFileName"=> "Events/Frontend/ShouldUseCachedPageDataIfAvailableEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Frontend\Event\AfterLinkIsGeneratedEvent::class,
        "targetFileName"=> "Events/Frontend/AfterLinkIsGeneratedEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Frontend\Event\BeforePageIsResolvedEvent::class,
        "targetFileName"=> "Events/Frontend/BeforePageIsResolvedEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Frontend\Event\AfterPageAndLanguageIsResolvedEvent::class,
        "targetFileName"=> "Events/Frontend/AfterPageAndLanguageIsResolvedEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Frontend\Event\AfterPageWithRootLineIsResolvedEvent::class,
        "targetFileName"=> "Events/Frontend/AfterPageWithRootLineIsResolvedEvent.rst.txt",
        "withCode"=> false
    ],
    // TYPO3 12.0
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Frontend\Event\AfterCacheableContentIsGeneratedEvent::class,
        "targetFileName"=> "Events/Frontend/AfterCacheableContentIsGeneratedEvent.rst.txt",
        "withCode"=> false
    ],
    [
        "action"=> "createPhpClassDocs",
        "class"=> \TYPO3\CMS\Frontend\Event\AfterCachedPageIsPersistedEvent::class,
        "targetFileName"=> "Events/Frontend/AfterCachedPageIsPersistedEvent.rst.txt",
        "withCode"=> false
    ],
];