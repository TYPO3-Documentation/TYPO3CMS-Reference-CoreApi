<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyDeleteRepository
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    public function deleteSomeData()
    {
        $this->connectionPool->getConnectionForTable('tt_content')
            ->delete(
                'tt_content', // from
                ['uid' => 4711],  // where
            );
    }
}
