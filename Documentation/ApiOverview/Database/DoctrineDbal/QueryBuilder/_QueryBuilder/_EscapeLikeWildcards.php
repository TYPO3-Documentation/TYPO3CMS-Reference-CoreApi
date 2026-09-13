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

    public function findBySearchWordUsingLike(): void
    {
        // SELECT `uid` FROM `tt_content`
        //     WHERE (`bodytext` LIKE '%kl\\%aus%')
        $searchWord = 'kl%aus';
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_content');
        $queryBuilder
            ->select('uid')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->like(
                    'bodytext',
                    $queryBuilder->createNamedParameter(
                        '%' . $queryBuilder
                            ->escapeLikeWildcards($searchWord) . '%',
                        Connection::PARAM_STR,
                    ),
                ),
            );
    }
}
