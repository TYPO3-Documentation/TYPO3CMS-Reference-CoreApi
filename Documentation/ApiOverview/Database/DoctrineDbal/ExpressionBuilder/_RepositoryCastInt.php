<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'my_table';
    public function __construct(private readonly ConnectionPool $connectionPool) {}

    public function demonstrateCastInt(): void
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE_NAME);

        $queryBuilder
            ->select('uid')
            ->from('pages');

        // simple value (quoted) to be used as sub-expression
        $expression1 = $queryBuilder->expr()->castInt(
            $queryBuilder->quote('123'),
        );

        // simple value (quoted) to return as select field
        $queryBuilder->addSelectLiteral(
            $queryBuilder->expr()->castInt(
                $queryBuilder->quote('123'),
                'virtual_field',
            ),
        );

        // cast the contents of a specific field to integer
        $expression3 = $queryBuilder->expr()->castInt(
            $queryBuilder->quoteIdentifier('uid'),
        );

        // expression to be used as sub-expression
        $expression4 = $queryBuilder->expr()->castInt(
            $queryBuilder->expr()->castVarchar('(1 * 10)'),
        );

        // expression to return as select field
        $queryBuilder->addSelectLiteral(
            $queryBuilder->expr()->castInt(
                $queryBuilder->expr()->castVarchar('(1 * 10)'),
                'virtual_field',
            ),
        );
    }
}
