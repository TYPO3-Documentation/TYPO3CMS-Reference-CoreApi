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
        'class' => \TYPO3\CMS\Core\Localization\TranslatorInterface::class,
        'targetFileName' => 'ApiOverview/Localization/LocalizationApi/_TranslatorInterface.rst.txt',
        'withCode' => false,
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Localization\Locale::class,
        'targetFileName' => 'ApiOverview/Localization/LocalizationApi/_Locale.rst.txt',
        'withCode' => false,
    ],
];
