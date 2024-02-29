<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Utility;

use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class MyUtility
{
    private static function translateSomething(string $lll): string
    {
        $languageServiceFactory = GeneralUtility::makeInstance(
            LanguageServiceFactory::class,
        );
        // As we are in a static context we cannot get the current request in
        // another way this usually points to general flaws in your software-design
        $request = $GLOBALS['TYPO3_REQUEST'];
        $languageService = $languageServiceFactory->createFromSiteLanguage(
            $request->getAttribute('language')
            ?? $request->getAttribute('site')->getDefaultLanguage(),
        );
        return $languageService->sL($lll);
    }
}
