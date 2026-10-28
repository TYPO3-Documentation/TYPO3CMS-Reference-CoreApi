<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use MyVendor\MyExtension\Domain\Model\Conference;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ConferenceRepository extends Repository
{
  /**
   * @param int[] $storagePageIds
   * @return QueryResultInterface<Conference>
   */
  public function findPublishedBefore(
    \DateTimeImmutable $date,
    array $storagePageIds,
  ): QueryResultInterface {
    $query = $this->createQuery();
    $query->getQuerySettings()->setStoragePageIds($storagePageIds);
    $query->matching(
      $query->logicalAnd(
        $query->equals('published', true),
        $query->lessThan('conferenceDate', $date),
      ),
    );

    return $query->execute();
  }
}
