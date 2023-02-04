<?php
declare(strict_types=1);

namespace MyVendor\MyExtension\Backend;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;

final class MyUserFunction
{
    private LanguageServiceFactory $languageServiceFactory;

    public function __construct(LanguageServiceFactory $languageServiceFactory) {
        $this->languageServiceFactory = $languageServiceFactory;
    }

    private function getLanguageService(ServerRequestInterface $request): LanguageService
    {
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
        return $this->getLanguageService($request)->getLL(
            'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:something.'
        );
    }
}