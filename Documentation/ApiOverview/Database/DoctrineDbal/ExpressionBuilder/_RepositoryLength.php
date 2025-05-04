<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

final class MyTableRepository
{
    private const TABLE_NAME = 'tt_content';
    public function __construct(private readonly ConnectionPool $connectionPool) {}

    public function findFieldLongerThenZero(string $fieldName): QueryBuilder
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLE_NAME);
        $queryBuilder->expr()->comparison(
            $queryBuilder->expr()->length($fieldName),
            ExpressionBuilder::GT,
            $queryBuilder->createNamedParameter(0, Connection::PARAM_INT),
        );
        return $queryBuilder;
    }
}
