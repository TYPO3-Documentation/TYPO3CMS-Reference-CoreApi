<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

final class MyTableRepository
{
    private const TABLE_NAME = 'tx_myextension_table';
    public function __construct(private readonly ConnectionPool $connectionPool) {}

    public function demonstrateExpressionBuilderAs(): QueryBuilder
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE_NAME);
        $expressionBuilder = $queryBuilder->expr();

        $queryBuilder->selectLiteral(
            $queryBuilder->quoteIdentifier('uid'),
            $expressionBuilder->as('(1 + 1 + 1)', 'calculated_field'),
        );

        return $queryBuilder->selectLiteral(
            $queryBuilder->quoteIdentifier('uid'),
            $expressionBuilder->as(
                $expressionBuilder->concat(
                    $expressionBuilder->literal('1'),
                    $expressionBuilder->literal(' '),
                    $expressionBuilder->literal('1'),
                ),
                'concatenated_value',
            ),
        );
    }
}
