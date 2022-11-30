<?php

declare(strict_types=1);

namespace Vendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

class MyDeleteRepository
{
    private ConnectionPool $connectionPool;

    public function __construct(ConnectionPool $connectionPool)
    {
        $this->connectionPool = $connectionPool;
    }

    public function deleteSomeData()
    {
        $this->connectionPool->getConnectionForTable('tt_content')
            ->delete(
                'tt_content', // from
                ['uid' => 4711]  // where
            );
    }
}
