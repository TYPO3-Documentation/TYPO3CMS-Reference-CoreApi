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

    public function countSomething(
        int $something,
    ): int {
        $connection = $this->connectionPool
            ->getConnectionForTable(self::TABLE_NAME);
        return $connection->count(
            '*',
            self::TABLE_NAME,
            ['some_value' => $something],
        );
    }
}
