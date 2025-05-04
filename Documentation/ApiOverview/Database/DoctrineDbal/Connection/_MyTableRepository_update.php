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

    public function updateSomething(
        int $uid,
        string $someValue,
        array $someData,
    ): void {
        $this->connectionPool
            ->getConnectionForTable(self::TABLE_NAME)
            ->update(
                self::TABLE_NAME,
                [
                    'some_value' => $someValue,
                    'json_data' => $someData,
                ],
                ['uid' => $uid],
                [Connection::PARAM_INT],
            );
    }
}
