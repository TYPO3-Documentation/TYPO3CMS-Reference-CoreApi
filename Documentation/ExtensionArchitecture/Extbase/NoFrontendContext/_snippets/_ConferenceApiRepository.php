<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use MyVendor\MyExtension\Domain\Model\Conference;
use TYPO3\CMS\Core\Context\LanguageAspect;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ConferenceRepository extends Repository
{
  /**
   * @param int[] $storagePageIds
   * @return QueryResultInterface<Conference>
   */
  public function findPublishedForApi(
    array $storagePageIds,
    LanguageAspect $languageAspect,
  ): QueryResultInterface {
    $query = $this->createQuery();
    $query->getQuerySettings()
      ->setStoragePageIds($storagePageIds)
      ->setLanguageAspect($languageAspect);
    $query->matching($query->equals('published', true));
    $query->setOrderings(['conferenceDate' => QueryInterface::ORDER_ASCENDING]);

    return $query->execute();
  }
}
