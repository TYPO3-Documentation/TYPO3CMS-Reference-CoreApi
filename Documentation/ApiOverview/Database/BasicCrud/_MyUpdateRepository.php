<?php

declare(strict_types=1);

namespace Vendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

class MyUpdateRepository
{
    private ConnectionPool $connectionPool;

    public function __construct(ConnectionPool $connectionPool)
    {
        $this->connectionPool = $connectionPool;
    }

    public function updateSomeData()
    {
        $this->connectionPool->getConnectionForTable('tt_content')
            ->update(
                'tt_content',
                [ 'bodytext' => 'bernd' ], // set
                [ 'bodytext' => 'klaus' ]  // where
            );
    }
}
