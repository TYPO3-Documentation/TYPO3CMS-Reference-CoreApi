<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'pages';
    public function __construct(private readonly ConnectionPool $connectionPool) {}

    public function demonstrateRightPad(): void
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE_NAME);
        // Right-pad the string "123" up to ten times with "0", resulting in "1230000000"
        $expression1 = $queryBuilder->expr()->rightPad(
            $queryBuilder->quote('123'),
            10,
            '0',
        );

        // Right-pad the cnotents of field "uid" up to ten times with 0, for uid=1 results in "1000000000".
        $expression2 = $queryBuilder->expr()->rightPad(
            $queryBuilder->expr()->castVarchar($queryBuilder->quoteIdentifier('uid')),
            10,
            '0',
        );

        // Right-pad the results of concatenating "1" + "2" + "3" ("123") up to 10 times with 0, resulting in "1230000000"
        $expression3 = $queryBuilder->expr()->rightPad(
            $queryBuilder->expr()->concat(
                $queryBuilder->quote('1'),
                $queryBuilder->quote('2'),
                $queryBuilder->quote('3'),
            ),
            10,
            '0',
        );

        // Left-pad the result of sub-expression casting "1123" to a string,
        // resulting in "1123000000""
        $expression4 = $queryBuilder->expr()->rightPad(
            $queryBuilder->expr()->castVarchar('( 1123 )'),
            10,
            '0',
        );

        // Right-pad the string "123" up to 10 times with "0" and make the result ("1230000000") available as "virtual_field"
        $expression5 = $queryBuilder->expr()->rightPad(
            $queryBuilder->quote('123'),
            10,
            '0',
            'virtual_field',
        );
    }
}
