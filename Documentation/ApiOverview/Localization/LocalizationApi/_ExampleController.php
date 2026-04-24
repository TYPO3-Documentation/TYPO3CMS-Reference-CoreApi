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
            'my_extension.messages:labels.exampleLabel',
        );
        // ...

        return $content;
    }

    private function getTranslatedLabel(string $key): string
    {
        $language = $this->request->getAttribute('language')
            ?? $this->request->getAttribute('site')->getDefaultLanguage();
        /** @var \TYPO3\CMS\Core\Localization\TranslatorInterface $translator */
        $translator = $this->languageServiceFactory
            ->createFromSiteLanguage($language);

        return $translator->label($key);
    }
}
