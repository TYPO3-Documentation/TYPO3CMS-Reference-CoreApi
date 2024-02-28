<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyUpdateRepository
{
    public function __construct(
        private readonly ConnectionPool $connectionPool,
    ) {}

    public function updateSomeData()
    {
        $this->connectionPool->getConnectionForTable('tt_content')
            ->update(
                'tt_content',
                [ 'bodytext' => 'ipsum' ], // set
                [ 'bodytext' => 'lorem' ], // where
            );
    }
}
