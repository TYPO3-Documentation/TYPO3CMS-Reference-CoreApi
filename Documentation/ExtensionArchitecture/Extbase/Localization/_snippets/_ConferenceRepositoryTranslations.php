<?php

namespace MyVendor\MyExtension\Domain\Repository;

use MyVendor\MyExtension\Domain\Model\Conference;
use TYPO3\CMS\Core\Context\LanguageAspect;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ConferenceRepository extends Repository
{
  /**
   * Like findAllForLanguageAspect(), but without the records that exist
   * only in the requested language, without a default language parent.
   *
   * @return QueryResultInterface<Conference>
   */
  public function findTranslationsForLanguageAspect(
    LanguageAspect $languageAspect,
  ): QueryResultInterface {
    $query = $this->createQuery();
    $query->getQuerySettings()->setLanguageAspect($languageAspect);
    $query->matching(
      $query->logicalOr(
        // Records in the default language and in "all languages"
        $query->in('sysLanguageUid', [0, -1]),
        // Translations with a default language parent
        $query->greaterThan('l10nParent', 0),
      ),
    );

    return $query->execute();
  }
}
