<?php

namespace MyVendor\MyExtension\Domain\Repository;

use MyVendor\MyExtension\Domain\Model\Conference;
use TYPO3\CMS\Core\Context\LanguageAspect;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ConferenceRepository extends Repository
{
  /**
   * Takes a ready-made language aspect, so the caller decides the language.
   * Usable from the frontend, a backend module and the command line alike.
   *
   * @return QueryResultInterface<Conference>
   */
  public function findAllForLanguageAspect(LanguageAspect $languageAspect): QueryResultInterface
  {
    $query = $this->createQuery();
    $query->getQuerySettings()->setLanguageAspect($languageAspect);

    return $query->execute();
  }
}
