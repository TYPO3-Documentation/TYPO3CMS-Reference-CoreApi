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
        // Returns the right-side 6 characters of "some-string" (result: "string")
        $expression1 = $queryBuilder->expr()->right(
            6,
            $queryBuilder->quote('some-string'),
        );

        // Returns the right-side calculated 7 characters of "some-string" (result: "-string")
        $expression2 = $queryBuilder->expr()->right(
            '(3+4)',
            $queryBuilder->quote('some-string'),
        );

        // Returns a sub-expression (casting "8" as integer) to return "g-string"
        $expression3 = $queryBuilder->expr()->right(
            $queryBuilder->expr()->castInt('(8)'),
            $queryBuilder->quote('some-very-log-string'),
        );

        // Return the right-side 23 characters from column "table_field_name"
        $expression4 = $queryBuilder->expr()->right(
            23,
            $queryBuilder->quoteIdentifier('table_field_name'),
        );
    }
}
