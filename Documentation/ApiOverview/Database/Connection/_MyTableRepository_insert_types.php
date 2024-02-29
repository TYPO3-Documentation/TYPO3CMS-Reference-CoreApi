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

    public function insertSomething(
        int $pid,
        string $someString,
    ): void {
        $this->connectionPool
            ->getConnectionForTable(self::TABLE_NAME)
            ->insert(
                self::TABLE_NAME,
                [
                    'pid' => $pid,
                    'some_string' => $someString,
                ],
                [
                    Connection::PARAM_INT,
                    Connection::PARAM_STR,
                ],
            );
    }
}
