<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use Doctrine\DBAL\Result;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;

final readonly class MyDbalRepository
{
    public function __construct(
        private ConnectionPool $connectionPool,
    ) {}

    public function findByBodytextOrHeader(): Result
    {
        // SELECT `uid`, `header`, `bodytext`
        // FROM `tt_content`
        // WHERE
        //    (
        //       ((`bodytext` = 'lorem') AND (`header` = 'a name'))
        //       OR (`bodytext` = 'dolor') OR (`bodytext` = 'hans')
        //    )
        //    AND (`pid` = 42)
        //    AND ... RestrictionBuilder TCA restrictions ...
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_content');
        return $queryBuilder
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
                $queryBuilder->expr()->eq(
                    'header',
                    $queryBuilder->createNamedParameter(
                        'a name',
                        Connection::PARAM_STR,
                    ),
                ),
            )
            ->orWhere(
                $queryBuilder->expr()->eq(
                    'bodytext',
                    $queryBuilder->createNamedParameter('dolor'),
                ),
                $queryBuilder->expr()->eq(
                    'bodytext',
                    $queryBuilder->createNamedParameter('hans'),
                ),
            )
            ->andWhere(
                $queryBuilder->expr()->eq(
                    'pid',
                    $queryBuilder->createNamedParameter(
                        42,
                        Connection::PARAM_INT,
                    ),
                ),
            )
            ->executeQuery();
    }
}
