<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'pages';
    public function __construct(private readonly ConnectionPool $connectionPool) {}

    public function demonstrateRight(): void
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE_NAME);
        $expression1 = $queryBuilder->expr()->right(
            6,
            $queryBuilder->quote('some-string'),
        );

        $expression2 = $queryBuilder->expr()->right(
            '6',
            $queryBuilder->quote('some-string'),
        );

        $expression3 = $queryBuilder->expr()->right(
            $queryBuilder->expr()->castInt('(23)'),
            $queryBuilder->quote('some-string'),
        );

        $expression4 = $queryBuilder->expr()->right(
            $queryBuilder->expr()->castInt('(23)'),
            $queryBuilder->quoteIdentifier('table_field_name'),
        );
    }
}
