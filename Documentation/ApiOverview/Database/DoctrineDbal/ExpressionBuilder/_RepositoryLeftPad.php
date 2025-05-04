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
        // Left-pad "123" with "0" to an amount of 10 times, resulting in "0000000123"
        $expression1 = $queryBuilder->expr()->leftPad(
            $queryBuilder->quote('123'),
            10,
            '0',
        );

        // Left-pad contents of the "uid" field with "0" to an amount of 10 times, a uid=1 would return "0000000001"
        $expression2 = $queryBuilder->expr()->leftPad(
            $queryBuilder->expr()->castVarchar($queryBuilder->quoteIdentifier('uid')),
            10,
            '0',
        );

        // Sub-expression to left-pad the concated string result ("1" + "2" + "3") up to 10 times with 0, resulting in "0000000123".
        $expression3 = $queryBuilder->expr()->leftPad(
            $queryBuilder->expr()->concat(
                $queryBuilder->quote('1'),
                $queryBuilder->quote('2'),
                $queryBuilder->quote('3'),
            ),
            10,
            '0',
        );

        // Left-pad the result of sub-expression casting "1123" to a string,
        // resulting in "0000001123".
        $expression4 = $queryBuilder->expr()->leftPad(
            $queryBuilder->expr()->castVarchar('( 1123 )'),
            10,
            '0',
        );

        // Left-pad the result of sub-expression casting "1123" to a string,
        // resulting in "0000001123" being assigned to "virtual_field"
        $expression5 = $queryBuilder->expr()->leftPad(
            $queryBuilder->expr()->castVarchar('( 1123 )'),
            10,
            '0',
            'virtual_field',
        );
    }
}
