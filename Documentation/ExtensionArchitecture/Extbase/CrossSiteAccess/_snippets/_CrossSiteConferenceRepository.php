<?php

namespace MyVendor\MyExtension\Domain\Repository;

use MyVendor\MyExtension\Domain\Model\Conference;
use TYPO3\CMS\Core\Context\LanguageAspect;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ConferenceRepository extends Repository
{
  /**
   * Reads conferences from storage pages that need not belong to the current
   * site, in the language the caller resolved for those pages.
   *
   * @param int[] $storagePageIds
   * @return QueryResultInterface<Conference>
   */
  public function findAllInStorage(
    array $storagePageIds,
    LanguageAspect $languageAspect,
  ): QueryResultInterface {
    $query = $this->createQuery();
    $querySettings = $query->getQuerySettings();

    $querySettings->setStoragePageIds($storagePageIds);
    $querySettings->setLanguageAspect($languageAspect);

    return $query->execute();
  }
}
