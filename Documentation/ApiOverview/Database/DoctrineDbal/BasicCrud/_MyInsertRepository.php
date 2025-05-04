<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyInsertRepository
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    public function insertSomeData(): void
    {
        $this->connectionPool
            ->getConnectionForTable('tt_content')
            ->insert(
                'tt_content',
                [
                    'pid' => 42,
                    'bodytext' => 'ipsum',
                ],
            );
    }
}
