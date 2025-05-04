<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'pages';
    public function __construct(private readonly ConnectionPool $connectionPool) {}

    public function demonstrateRepeat(): void
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE_NAME);
        // Repeats "." 10 times, resulting in ".........."
        $expression1 = $queryBuilder->expr()->repeat(
            10,
            $queryBuilder->quote('.'),
        );

        // Repeats "0" 20 times and allows to access the field as "aliased_field" in query / result
        $expression2 = $queryBuilder->expr()->repeat(
            20,
            $queryBuilder->quote('0'),
            $queryBuilder->quoteIdentifier('aliased_field'),
        );

        // Repeat contents of field "table_field" 20 times and makes it available as "aliased_field"
        $expression3 = $queryBuilder->expr()->repeat(
            20,
            $queryBuilder->quoteIdentifier('table_field'),
            $queryBuilder->quoteIdentifier('aliased_field'),
        );

        // Repeate database field "table_field" the number of times that is cast to integer from the field "repeat_count_field" and make it available as "aliased_field"
        $expression4 = $queryBuilder->expr()->repeat(
            $queryBuilder->expr()->castInt(
                $queryBuilder->quoteIdentifier('repeat_count_field'),
            ),
            $queryBuilder->quoteIdentifier('table_field'),
            $queryBuilder->quoteIdentifier('aliased_field'),
        );

        // Repeats the character "." as many times as the result of the expression "7+3" (10 times)
        $expression5 = $queryBuilder->expr()->repeat(
            '(7 + 3)',
            $queryBuilder->quote('.'),
        );

        // Repeat 10 times the result of a concatenation expression (".") and make it available as "virtual_field_name"
        $expression6 = $queryBuilder->expr()->repeat(
            '(7 + 3)',
            $queryBuilder->expr()->concat(
                $queryBuilder->quote(''),
                $queryBuilder->quote('.'),
                $queryBuilder->quote(''),
            ),
            'virtual_field_name',
        );
    }
}
