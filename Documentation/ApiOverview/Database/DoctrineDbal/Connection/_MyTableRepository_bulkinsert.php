<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'tx_myextension_mytable';

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    public function bulkInsertSomething(
        int $pid1,
        int $pid2,
        string $someString1,
        string $someString2,
    ): void {
        $this->connectionPool
            ->getConnectionForTable(self::TABLE_NAME)
            ->bulkInsert(
                self::TABLE_NAME,
                [
                    [$pid1, $someString1],
                    [$pid2, $someString2],
                ],
                [
                    'pid',
                    'title',
                ],
                [
                    Connection::PARAM_INT,
                    Connection::PARAM_STR,
                ],
            );
    }
}
