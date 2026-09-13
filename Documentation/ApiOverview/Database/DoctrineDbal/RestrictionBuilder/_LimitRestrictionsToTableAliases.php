<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final readonly class ContentDbalRepository
{
  public function __construct(
    private ConnectionPool $connectionPool,
  ) {}

  public function findWithParentContent(): void
  {
    $queryBuilder = $this->connectionPool
        ->getQueryBuilderForTable('tt_content');
    $queryBuilder->getRestrictions()
        ->removeAll()
        ->add(GeneralUtility::makeInstance(HiddenRestriction::class));
    $queryBuilder->getRestrictions()->limitRestrictionsToTables(['c2']);
    $queryBuilder
        ->select('c1.*')
        ->from('tt_content', 'c1')
        ->leftJoin('c1', 'tt_content', 'c2', 'c1.parent_field = c2.uid')
        ->orWhere(
          $queryBuilder->expr()->isNull('c2.uid'),
          $queryBuilder->expr()->eq(
            'c2.pid',
            $queryBuilder->createNamedParameter(
              1,
              Connection::PARAM_INT,
            ),
          ),
        );
  }
}
