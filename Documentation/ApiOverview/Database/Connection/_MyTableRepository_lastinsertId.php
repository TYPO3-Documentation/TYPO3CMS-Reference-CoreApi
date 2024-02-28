<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'tx_myextension_mytable';

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    public function insertSomething(
        array $someData,
    ): int {
        $connection = $this->connectionPool
            ->getConnectionForTable(self::TABLE_NAME);
        $connection
            ->insert(
                self::TABLE_NAME,
                $someData,
            );
        return (int)$connection->lastInsertId();
    }
}
