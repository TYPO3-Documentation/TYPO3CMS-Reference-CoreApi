<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'my_table';
    public function __construct(private readonly ConnectionPool $connectionPool) {}

    public function demonstrateCastVarchar(): void
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE_NAME);

        $fieldVarcharCastExpression = $queryBuilder->expr()->castVarchar(
            $queryBuilder->quote('123'), // integer as string
            255,                         // convert to varchar(255) field - dynamic length
            'new_field_identifier',
        );

        $fieldExpressionCastExpression2 = $queryBuilder->expr()->castVarchar(
            '(100 + 200)',           // calculate a integer value
            100,                     // dynamic varchar(100) field
            'new_field_identifier',
        );
    }
}
