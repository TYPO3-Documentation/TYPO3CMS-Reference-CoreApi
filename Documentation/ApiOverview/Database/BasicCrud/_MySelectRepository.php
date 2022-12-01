<?php

declare(strict_types=1);

namespace Vendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MySelectRepository
{
    private ConnectionPool $connectionPool;

    public function __construct(ConnectionPool $connectionPool)
    {
        $this->connectionPool = $connectionPool;
    }

    /**
     * @return array|false
     */
    public function selectSomeData()
    {
        $uid = 4;

        return $this->connectionPool
            ->getConnectionForTable('tt_content')
            ->select(
                ['uid', 'pid', 'bodytext'], // fields to select
                'tt_content',               // from
                ['uid' => $uid]             // where
            )
            ->fetchAssociative();
    }
}
