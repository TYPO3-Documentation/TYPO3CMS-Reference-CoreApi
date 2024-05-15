<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'pages';
    public function __construct(private readonly ConnectionPool $connectionPool) {}

    public function demonstrateSpace(): void
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE_NAME);
        // Returns "          " (10 space characters)
        $expression1 = $queryBuilder->expr()->space(
            '10',
        );

        // Returns "          " (10 space characters) and makes available as "aliased_field"
        $expression2 = $queryBuilder->expr()->space(
            '20',
            $queryBuilder->quoteIdentifier('aliased_field'),
        );

        // Return amount of space characters based on calculation (10 spaces)
        $expression3 = $queryBuilder->expr()->space(
            '(7+2+1)',
        );

        // Return amount of space characters based on a fixed value (210 spaces) and make available as "aliased_field"
        $expression3 = $queryBuilder->expr()->space(
            '(210)',
            $queryBuilder->quoteIdentifier('aliased_field'),
        );

        // Return a space X times, where X is the contents of the field table_repeat_number_field
        $expression5 = $queryBuilder->expr()->space(
            $queryBuilder->expr()->castInt(
                $queryBuilder->quoteIdentifier('table_repeat_number_field'),
            ),
        );

        $expression6 = $queryBuilder->expr()->space(
            $queryBuilder->expr()->castInt(
                $queryBuilder->quoteIdentifier('table_repeat_number_field'),
            ),
            $queryBuilder->quoteIdentifier('aliased_field'),
        );
    }
}
