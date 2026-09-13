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

    public function updateBodytextUsingAlias(): void
    {
        // UPDATE `tt_content` `t` SET `t`.`bodytext` = 'dolor'
        //     WHERE `t`.`bodytext` = 'lorem'
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_content');
        $queryBuilder
            ->update('tt_content', 't')
            ->where(
                $queryBuilder->expr()->eq(
                    't.bodytext',
                    $queryBuilder->createNamedParameter(
                        'lorem',
                        Connection::PARAM_STR,
                    ),
                ),
            )
            ->set('t.bodytext', 'dolor')
            ->executeStatement();
    }
}
