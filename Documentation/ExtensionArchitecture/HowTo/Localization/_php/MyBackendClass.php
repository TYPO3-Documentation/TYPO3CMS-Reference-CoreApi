<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Localization\TranslatorInterface;

final class MyBackendClass
{
    public function __construct(
        private readonly LanguageServiceFactory $languageServiceFactory,
    ) {}

    private function translateSomething(string $input): string
    {
        return $this->getTranslator()->label($input);
    }

    private function getTranslator(): TranslatorInterface
    {
        return $this->languageServiceFactory
            ->createFromUserPreferences($this->getBackendUserAuthentication());
    }

    private function getBackendUserAuthentication(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    // ...
}
