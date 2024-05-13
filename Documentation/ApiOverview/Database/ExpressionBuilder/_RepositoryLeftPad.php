<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'tt_content';
    public function __construct(private readonly ConnectionPool $connectionPool) {}

    public function demonstrateLeftPad(): void
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE_NAME);
        $expression1 = $queryBuilder->expr()->leftPad(
            $queryBuilder->quote('123'),
            10,
            '0',
        );

        $expression2 = $queryBuilder->expr()->leftPad(
            $queryBuilder->expr()->castVarchar($queryBuilder->quoteIdentifier('uid')),
            10,
            '0',
        );

        $expression3 = $queryBuilder->expr()->leftPad(
            $queryBuilder->expr()->concat(
                $queryBuilder->quote('1'),
                $queryBuilder->quote('2'),
                $queryBuilder->quote('3'),
            ),
            10,
            '0',
        );

        $expression4 = $queryBuilder->expr()->leftPad(
            $queryBuilder->expr()->castVarchar('( 1123 )'),
            10,
            '0',
        );

        $expression5 = $queryBuilder->expr()->leftPad(
            $queryBuilder->expr()->castVarchar('( 1123 )'),
            10,
            '0',
            'virtual_field',
        );
    }
}
