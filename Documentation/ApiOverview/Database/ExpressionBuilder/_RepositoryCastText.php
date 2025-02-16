<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'my_table';

    public function __construct(private readonly ConnectionPool $connectionPool) {}

    public function demonstrateCastText(string $col1, string $col2): array
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE_NAME);

        return $queryBuilder
            ->selectLiteral(
                $queryBuilder->quoteIdentifier($col1),
                $queryBuilder->quoteIdentifier($col2),
                // !!! Escape all values passed to castText to prevent SQL injections
                $queryBuilder->expr()->castText(
                    $queryBuilder->quoteIdentifier($col2) . ' * 10',
                    'virtual_field',
                ),
            )
            ->from(self::TABLE_NAME)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
