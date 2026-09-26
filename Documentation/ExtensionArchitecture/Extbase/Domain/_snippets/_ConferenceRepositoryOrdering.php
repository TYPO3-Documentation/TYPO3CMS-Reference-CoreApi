<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use MyVendor\MyExtension\Domain\Model\Conference;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ConferenceRepository extends Repository
{
  protected $defaultOrderings = [
    'conferenceDate' => QueryInterface::ORDER_ASCENDING,
    'title' => QueryInterface::ORDER_ASCENDING,
  ];

  /** @return QueryResultInterface<Conference> */
  public function findUpcomingByTitle(): QueryResultInterface
  {
    $query = $this->createQuery();
    $query->matching(
      $query->greaterThanOrEqual(
        'conferenceDate',
        new \DateTimeImmutable('today'),
      ),
    );
    $query->setOrderings(['title' => QueryInterface::ORDER_ASCENDING]);
    return $query->execute();
  }
}
