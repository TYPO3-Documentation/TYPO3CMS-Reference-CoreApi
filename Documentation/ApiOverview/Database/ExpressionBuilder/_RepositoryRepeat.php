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
        $expression1 = $queryBuilder->expr()->repeat(
            10,
            $queryBuilder->quote('.'),
        );

        $expression2 = $queryBuilder->expr()->repeat(
            20,
            $queryBuilder->quote('0'),
            $queryBuilder->quoteIdentifier('aliased_field'),
        );

        $expression3 = $queryBuilder->expr()->repeat(
            20,
            $queryBuilder->quoteIdentifier('table_field'),
            $queryBuilder->quoteIdentifier('aliased_field'),
        );

        $expression4 = $queryBuilder->expr()->repeat(
            $queryBuilder->expr()->castInt(
                $queryBuilder->quoteIdentifier('repeat_count_field'),
            ),
            $queryBuilder->quoteIdentifier('table_field'),
            $queryBuilder->quoteIdentifier('aliased_field'),
        );

        $expression5 = $queryBuilder->expr()->repeat(
            '(7 + 3)',
            $queryBuilder->quote('.'),
        );

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
