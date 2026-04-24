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

    public function doSomething(): string
    {
        $translation = $this->languageServiceFactory->create(new Locale('de-CH'));
        return $translation->translate('my-label', 'my_extension.myfile');
    }
}
