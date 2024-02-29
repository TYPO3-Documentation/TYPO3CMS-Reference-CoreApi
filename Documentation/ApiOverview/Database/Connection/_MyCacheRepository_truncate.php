<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyCacheRepository
{
    private const TABLE_NAME = 'cache_myextension';

    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    public function truncateSomething(
        int $uid,
    ): void {
        $this->connectionPool
            ->getConnectionForTable(self::TABLE_NAME)
            ->truncate(self::TABLE_NAME);
    }
}
