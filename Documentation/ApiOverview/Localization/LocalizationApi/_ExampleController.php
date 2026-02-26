<?php

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;

final class ExampleController
{
    private ServerRequestInterface $request;

    public function __construct(
        private readonly LanguageServiceFactory $languageServiceFactory,
    ) {}

    public function processAction(
        string $content,
        array $configurations,
        ServerRequestInterface $request,
    ): string {
        $this->request = $request;

        // ...
        $content .=  $this->getTranslatedLabel(
            'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:labels.exampleLabel',
        );
        // ...

        return $content;
    }

    private function getTranslatedLabel(string $key): string
    {
        $language = $this->request->getAttribute('language')
            ?? $this->request->getAttribute('site')->getDefaultLanguage();
        $languageService = $this->languageServiceFactory
            ->createFromSiteLanguage($language);

        return $languageService->sL($key);
    }
}
