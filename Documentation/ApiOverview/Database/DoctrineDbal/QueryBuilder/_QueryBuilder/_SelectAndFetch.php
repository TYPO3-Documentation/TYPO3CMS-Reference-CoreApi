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

    public function findByBodytext(): void
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_content');
        $result = $queryBuilder
            ->select('uid', 'header', 'bodytext')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    'bodytext',
                    $queryBuilder->createNamedParameter(
                        'lorem',
                        Connection::PARAM_STR,
                    ),
                ),
            )
            ->executeQuery();

        while ($row = $result->fetchAssociative()) {
            // Do something with that single row
            debug($row);
        }
    }
}
