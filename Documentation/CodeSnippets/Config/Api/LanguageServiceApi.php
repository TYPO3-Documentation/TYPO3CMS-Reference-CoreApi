<?php

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::class,
        'targetFileName' => 'ApiOverview/Localization/LocalizationApi/_LocalizationUtilityApi.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Localization\LanguageServiceFactory::class,
        'targetFileName' => 'ApiOverview/Localization/LocalizationApi/_LanguageServiceFactory.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Localization\LanguageService::class,
        'targetFileName' => 'ApiOverview/Localization/LocalizationApi/_LanguageService.rst.txt',
        'withCode' => false,
    ],
];
