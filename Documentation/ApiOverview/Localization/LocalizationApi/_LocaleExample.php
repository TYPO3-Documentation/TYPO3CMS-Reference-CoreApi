<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Localization\Locale;

final class LocaleExample
{
    public function __construct(
        private readonly LanguageServiceFactory $languageServiceFactory,
    ) {}

    public function doSomething()
    {
        $languageService = $this->languageServiceFactory->create(new Locale('de-CH'));
        $myTranslatedString = $languageService->sL(
            'LLL:EXT:my_extension/Resources/Private/Language/myfile.xlf:my-label',
        );
    }
}
