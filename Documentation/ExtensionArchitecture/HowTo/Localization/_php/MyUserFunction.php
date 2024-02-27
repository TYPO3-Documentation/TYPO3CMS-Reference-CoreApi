<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;

final class MyUserFunction
{
    private LanguageService $languageService;

    public function __construct(
        private readonly LanguageServiceFactory $languageServiceFactory,
    ) {}

    private function getLanguageService(
        ServerRequestInterface $request
    ): LanguageService {
        return $this->languageServiceFactory->createFromSiteLanguage(
            $request->getAttribute('language')
            ?? $request->getAttribute('site')->getDefaultLanguage()
        );
    }

    public function main(
        string $content,
        array $conf,
        ServerRequestInterface $request
    ): string {
        $this->languageService = $this->getLanguageService($request);
        return $this->languageService->sL(
            'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:something'
        );
    }
}
