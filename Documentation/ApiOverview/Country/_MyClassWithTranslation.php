<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Country\CountryProvider;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Localization\Locale;

final class MyClassWithTranslation
{
    public function __construct(
        private readonly CountryProvider $countryProvider,
        private readonly LanguageServiceFactory $languageServiceFactory
    ) {}

    public function doSomething()
    {
        $languageService = $this->languageServiceFactory->create(new Locale('de'));
        $france = $this->countryProvider->getByIsoCode('FR');

        // "France"
        $france->getName();

        // "Frankreich"
        $languageService->sL($france->getLocalizedNameLabel());

        // "French Republic"
        echo $france->getOfficialName();

        // "Französische Republik"
        $languageService->sL($france->getLocalizedOfficialNameLabel());

        // 250
        $france->getNumericRepresentation();

        // "FR"
        $france->getAlpha2IsoCode();

        // "🇫🇷"
        $france->getFlag();
    }
}
