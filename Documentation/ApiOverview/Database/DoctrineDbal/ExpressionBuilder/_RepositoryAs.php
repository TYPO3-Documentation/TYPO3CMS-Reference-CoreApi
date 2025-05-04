<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'tx_myextension_table';
    public function __construct(private readonly ConnectionPool $connectionPool) {}

    public function demonstrateExpressionBuilderAs(): void
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE_NAME);
        $expressionBuilder = $queryBuilder->expr();

        // Alias the result of "1+1+1" as column "calculated_field" (containing "3")
        $queryBuilder->selectLiteral(
            $queryBuilder->quoteIdentifier('uid'),
            $expressionBuilder->as('(1 + 1 + 1)', 'calculated_field'),
        );

        // Alias a calculated sub-expression of concatenating "1", " " and "1" as
        // column "concatenated_value", containing "1 1".
        $queryBuilder->selectLiteral(
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
