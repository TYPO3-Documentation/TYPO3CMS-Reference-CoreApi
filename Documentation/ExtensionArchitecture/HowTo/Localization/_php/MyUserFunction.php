<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Localization\TranslatorInterface;

final class MyUserFunction
{
    private TranslatorInterface $translator;

    public function __construct(
        private readonly LanguageServiceFactory $languageServiceFactory,
    ) {}

    private function getTranslator(
        ServerRequestInterface $request,
    ): TranslatorInterface {
        return $this->languageServiceFactory->createFromSiteLanguage(
            $request->getAttribute('language')
            ?? $request->getAttribute('site')->getDefaultLanguage(),
        );
    }

    public function main(
        string $content,
        array $conf,
        ServerRequestInterface $request,
    ): string {
        $this->translator = $this->getTranslator($request);
        return $this->translator->label('my_extension.messages:something');
    }
}
