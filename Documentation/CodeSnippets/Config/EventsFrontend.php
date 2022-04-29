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
];