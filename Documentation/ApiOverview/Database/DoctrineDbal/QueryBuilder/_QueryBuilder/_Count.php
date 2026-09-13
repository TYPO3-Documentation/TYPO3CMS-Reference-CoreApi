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

    public function countByBodytext(): int
    {
        // SELECT COUNT(`uid`) FROM `tt_content`
        //     WHERE (`bodytext` = 'lorem')
        //     AND ((`tt_content`.`deleted` = 0)
        //     AND (`tt_content`.`hidden` = 0)
        //     AND (`tt_content`.`starttime` <= 1669885410)
        //     AND ((`tt_content`.`endtime` = 0)
        //     OR (`tt_content`.`endtime` > 1669885410)))
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_content');
        return (int)$queryBuilder
            ->count('uid')
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
            ->executeQuery()
            ->fetchOne();
    }
}
