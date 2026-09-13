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

    public function findBySearchWord(): Result
    {
        // SELECT * FROM `tt_content` WHERE (`bodytext` = 'kl\'aus')
        // $searchWord retrieved from the PSR-7 request
        $searchWord = "kl'aus";
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();
        return $queryBuilder
            ->select('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq(
                    'bodytext',
                    $queryBuilder->createNamedParameter(
                        $searchWord,
                        Connection::PARAM_STR,
                    ),
                ),
            )
            ->executeQuery();
    }
}
