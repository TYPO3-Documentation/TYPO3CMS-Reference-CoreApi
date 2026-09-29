<?php

namespace MyVendor\MyExtension\Domain\Repository;

use MyVendor\MyExtension\Domain\Model\Conference;
use MyVendor\MyExtension\Domain\Model\ConferenceDemand;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ConferenceRepository extends Repository
{
  /** @return QueryResultInterface<Conference> */
  public function findDemanded(ConferenceDemand $demand): QueryResultInterface
  {
    $query = $this->createQuery();
    $constraints = [];

    if ($demand->searchWord !== '') {
      $pattern = '%' . $demand->searchWord . '%';
      $constraints[] = $query->logicalOr(
        $query->like('title', $pattern),
        $query->like('description', $pattern),
      );
    }
    if ($demand->status === ConferenceDemand::STATUS_PUBLISHED) {
      $constraints[] = $query->equals('published', true);
    }
    if ($demand->status === ConferenceDemand::STATUS_UNPUBLISHED) {
      $constraints[] = $query->equals('published', false);
    }

    if ($constraints !== []) {
      $query->matching($query->logicalAnd(...$constraints));
    }
    $query->setOrderings(['title' => QueryInterface::ORDER_ASCENDING]);

    return $query->execute();
  }
}
