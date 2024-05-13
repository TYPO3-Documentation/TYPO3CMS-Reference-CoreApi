<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

final class MyTableRepository
{
    private const TABLE_NAME = 'tt_content';
    public function __construct(private readonly ConnectionPool $connectionPool) {}

    public function findSomething(): QueryBuilder
    {
        // WHERE
        //     (`tt_content`.`CType` = 'list')
        //     AND (
        //        (`tt_content`.`list_type` = 'example_pi1')
        //        OR
        //        (`tt_content`.`list_type` = 'example_pi2')
        //     )
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
        $queryBuilder->where(
            $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('list')),
            $queryBuilder->expr()->or(
                $queryBuilder->expr()->eq(
                    'list_type',
                    $queryBuilder->createNamedParameter('example_pi1', Connection::PARAM_STR),
                ),
                $queryBuilder->expr()->eq(
                    'list_type',
                    $queryBuilder->createNamedParameter('example_pi2', Connection::PARAM_STR),
                ),
            ),
        );
        return $queryBuilder;
    }
}
