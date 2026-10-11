<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use TYPO3\CMS\Core\Context\LanguageAspectFactory;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;

final readonly class TranslatedPageTitle
{
  public function __construct(
    private PageRepository $pageRepository,
  ) {}

  public function get(int $pageId, SiteLanguage $siteLanguage): string
  {
    $languageAspect = LanguageAspectFactory::createFromSiteLanguage(
      $siteLanguage,
    );
    // A new instance for this language, the injected one stays unchanged
    $page = $this->pageRepository
      ->withLanguageAspect($languageAspect)
      ->getPage($pageId);
    return (string)($page['title'] ?? '');
  }
}
