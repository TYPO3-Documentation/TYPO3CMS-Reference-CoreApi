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
        //     (`tt_content`.`CType` = 'header')
        //     AND (
        //        (`tt_content`.`header_position` = 'center')
        //        OR
        //        (`tt_content`.`header_position` = 'right')
        //     )
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLE_NAME);
        $queryBuilder->where(
            $queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('header')),
            $queryBuilder->expr()->or(
                $queryBuilder->expr()->eq(
                    'header_position',
                    $queryBuilder->createNamedParameter('center', Connection::PARAM_STR),
                ),
                $queryBuilder->expr()->eq(
                    'header_position',
                    $queryBuilder->createNamedParameter('right', Connection::PARAM_STR),
                ),
            ),
        );
        return $queryBuilder;
    }
}
