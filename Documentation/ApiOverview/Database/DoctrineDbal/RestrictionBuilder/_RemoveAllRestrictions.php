<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final readonly class MyClass
{
  public function __construct(
    private ConnectionPool $connectionPool,
  ) {}

  public function findContentOnPage(int $pid): array
  {
    // SELECT `uid`, `bodytext` FROM `tt_content`
    //     WHERE (`pid` = 42) AND (`tt_content`.`deleted` = 0)
    $queryBuilder = $this->connectionPool
        ->getQueryBuilderForTable('tt_content');
    // Remove all restrictions but add DeletedRestriction again
    $queryBuilder
        ->getRestrictions()
        ->removeAll()
        ->add(GeneralUtility::makeInstance(DeletedRestriction::class));
    return $queryBuilder
        ->select('uid', 'bodytext')
        ->from('tt_content')
        ->where(
          $queryBuilder->expr()->eq(
            'pid',
            $queryBuilder->createNamedParameter(
              $pid,
              Connection::PARAM_INT,
            ),
          ),
        )
        ->executeQuery()
        ->fetchAllAssociative();
  }
}
