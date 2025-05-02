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

    public function useQueryBuilder(
        array $someData,
    ): void {
        $connection = $this->connectionPool->getConnectionForTable(self::TABLE_NAME);
        foreach ($someData as $value) {
            $queryBuilder = $connection->createQueryBuilder();
            $myResult = $queryBuilder
                ->select('*')
                ->from(self::TABLE_NAME)
                ->where(
                    $queryBuilder->expr()->eq(
                        'some_field',
                        $queryBuilder->createNamedParameter($value),
                    ),
                )
                ->executeQuery()
                ->fetchAllAssociative();
            // do something
        }
    }
}
