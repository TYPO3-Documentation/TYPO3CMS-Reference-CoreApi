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

    public function deleteSomething(
        int $uid,
    ): void {
        $this->connectionPool
            ->getConnectionForTable(self::TABLE_NAME)
            ->delete(
                self::TABLE_NAME,
                ['uid' => $uid],
                [Connection::PARAM_INT],
            );
    }
}
