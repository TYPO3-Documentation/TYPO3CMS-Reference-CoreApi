<?php

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

return [
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Extbase\Utility\LocalizationUtility::class,
        'targetFileName' => 'Api/LocalizationApi/LocalizationUtilityApi.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Localization\LanguageServiceFactory::class,
        'targetFileName' => 'Api/LocalizationApi/LanguageServiceFactory.rst.txt',
        'withCode' => false
    ],
    [
        'action' => 'createPhpClassDocs',
        'class' => \TYPO3\CMS\Core\Localization\LanguageService::class,
        'targetFileName' => 'Api/LocalizationApi/LanguageService.rst.txt',
        'withCode' => false
    ],
];
