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

    public function findLanguagesOfTranslatedContent(): Result
    {
        // SELECT `tt_content_orig`.`sys_language_uid`
        // FROM `tt_content`
        // INNER JOIN `tt_content` `tt_content_orig`
        //     ON `tt_content`.`t3_origuid` = `tt_content_orig`.`uid`
        // INNER JOIN `sys_language` `sys_language`
        //     ON `tt_content_orig`.`sys_language_uid` = `sys_language`.`uid`
        // WHERE
        //     (`tt_content`.`colPos` = 1)
        //     AND (`tt_content`.`pid` = 42)
        //     AND (`tt_content`.`sys_language_uid` = 2)
        //     AND ... RestrictionBuilder TCA restrictions
        //         for tables tt_content and sys_language ...
        // GROUP BY `tt_content_orig`.`sys_language_uid`
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('sys_language');
        $constraints = [
            $queryBuilder->expr()->eq(
                'tt_content.colPos',
                $queryBuilder->createNamedParameter(1, Connection::PARAM_INT),
            ),
            $queryBuilder->expr()->eq(
                'tt_content.pid',
                $queryBuilder->createNamedParameter(42, Connection::PARAM_INT),
            ),
            $queryBuilder->expr()->eq(
                'tt_content.sys_language_uid',
                $queryBuilder->createNamedParameter(2, Connection::PARAM_INT),
            ),
        ];
        return $queryBuilder
            ->select('tt_content_orig.sys_language_uid')
            ->from('tt_content')
            ->join(
                'tt_content',
                'tt_content',
                'tt_content_orig',
                $queryBuilder->expr()->eq(
                    'tt_content.t3_origuid',
                    $queryBuilder->quoteIdentifier('tt_content_orig.uid'),
                ),
            )
            ->join(
                'tt_content_orig',
                'sys_language',
                'sys_language',
                $queryBuilder->expr()->eq(
                    'tt_content_orig.sys_language_uid',
                    $queryBuilder->quoteIdentifier('sys_language.uid'),
                ),
            )
            ->where(...$constraints)
            ->groupBy('tt_content_orig.sys_language_uid')
            ->executeQuery();
    }
}
