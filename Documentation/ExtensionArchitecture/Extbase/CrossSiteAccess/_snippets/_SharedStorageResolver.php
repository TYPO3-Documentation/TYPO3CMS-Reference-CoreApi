<?php

namespace MyVendor\MyExtension\Service;

use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Core\Site\SiteFinder;

/**
 * Resolves the pages and the language to use when reading records that belong
 * to another site.
 */
class SharedStorageResolver
{
  public function __construct(
    protected readonly SiteFinder $siteFinder,
  ) {}

  /**
   * The site the records belong to, identified by the site identifier
   */
  public function resolveStorageSite(string $siteIdentifier): Site
  {
    return $this->siteFinder->getSiteByIdentifier($siteIdentifier);
  }

  /**
   * Matches the language the visitor is browsing against the languages of the
   * storage site, using the locale as the join key.
   *
   * Returns null when the storage site does not offer the language at all,
   * which is a case the caller has to decide about — see the fallback
   * section of this chapter.
   */
  public function resolveStorageLanguage(
    Site $storageSite,
    SiteLanguage $currentLanguage,
  ): ?SiteLanguage {
    $wanted = (string)$currentLanguage->getLocale();

    foreach ($storageSite->getLanguages() as $candidate) {
      if ((string)$candidate->getLocale() === $wanted) {
        return $candidate;
      }
    }

    return null;
  }
}
