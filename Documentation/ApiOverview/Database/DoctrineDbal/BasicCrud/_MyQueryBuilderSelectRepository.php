<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class MyQueryBuilderSelectRepository
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    public function selectSomeData(): array
    {
        $uid = 4;

        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_content');

        // Remove all default restrictions (delete, hidden, starttime, stoptime),
        // but add DeletedRestriction again
        $queryBuilder->getRestrictions()
            ->removeAll()
            ->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        // Execute a query with "bodytext=lorem OR uid=4" and proper quoting
        return $queryBuilder
            ->select('uid', 'pid', 'bodytext')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->or(
                    $queryBuilder->expr()->eq(
                        'bodytext',
                        $queryBuilder->createNamedParameter('lorem'),
                    ),
                    $queryBuilder->expr()->eq(
                        'uid',
                        $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT),
                    ),
                ),
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
