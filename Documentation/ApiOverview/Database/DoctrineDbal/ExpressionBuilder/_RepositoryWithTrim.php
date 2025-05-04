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

    public function findFieldThatIsEmptyWhenTrimmed(string $fieldName): QueryBuilder
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable('tt_content');
        $queryBuilder->expr()->comparison(
            $queryBuilder->expr()->trim($fieldName),
            ExpressionBuilder::EQ,
            $queryBuilder->createNamedParameter('', Connection::PARAM_STR),
        );
        return $queryBuilder;
    }
}
