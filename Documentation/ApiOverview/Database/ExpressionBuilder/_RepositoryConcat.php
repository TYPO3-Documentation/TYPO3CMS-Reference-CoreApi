<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'pages';
    public function __construct(private readonly ConnectionPool $connectionPool) {}

    public function demonstrateConcat(): void
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(self::TABLE_NAME);
        $expressionBuilder = $queryBuilder->expr();
        $result = $queryBuilder
            ->select('uid', 'pid', 'title', 'page_title_info')
            ->addSelectLiteral(
                $expressionBuilder->concat(
                    $queryBuilder->quoteIdentifier('title'),
                    $queryBuilder->quote(' - ['),
                    $queryBuilder->quoteIdentifier('uid'),
                    $queryBuilder->quote('|'),
                    $queryBuilder->quoteIdentifier('pid'),
                    $queryBuilder->quote(']'),
                ) . ' AS ' . $queryBuilder->quoteIdentifier('page_title_info'),
            )
            ->where(
                $expressionBuilder->eq(
                    'pid',
                    $queryBuilder->createNamedParameter(0, Connection::PARAM_INT),
                ),
            )
            ->executeQuery();
        while ($row = $result->fetchAssociative()) {
            // $row = [
            //  'uid' => 1,
            //  'pid' => 0,
            //  'title' => 'Site Root Page',
            //  'page_title_info' => 'Site Root Page - [1|0]',
            // ]
            // ...
        }
    }
}
