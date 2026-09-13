<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

final readonly class MyDbalRepository
{
    public function __construct(
        private ConnectionPool $connectionPool,
    ) {}

    public function updateBodytext(): void
    {
        // UPDATE `tt_content` SET `bodytext` = 'dolor'
        //     WHERE `bodytext` = 'lorem'
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_content');
        $queryBuilder
            ->update('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    'bodytext',
                    $queryBuilder->createNamedParameter(
                        'lorem',
                        Connection::PARAM_STR,
                    ),
                ),
            )
            ->set('bodytext', 'dolor')
            ->executeStatement();
    }
}
