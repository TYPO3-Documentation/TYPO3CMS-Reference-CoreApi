<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use Doctrine\DBAL\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;

final class MyTableRepository
{
    private const TABLE_NAME = 'tt_content';
    public function __construct(private readonly ConnectionPool $connectionPool) {}

    /**
     * Calculate the average creation timestamp of all rows from tt_content
     * SELECT AVG(`crdate`) AS `averagecreation` FROM `tt_content`
     * @return array<mixed>
     * @throws Exception
     */
    public function findAverageCreationTime(): array
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLE_NAME);
        $result = $queryBuilder
            ->addSelectLiteral(
                $queryBuilder->expr()->avg('crdate', 'averagecreation'),
            )
            ->from(self::TABLE_NAME)
            ->executeQuery()
            ->fetchAssociative();
        return $result;
    }

    /**
     * Distinct list of all existing endtime values from tt_content
     * SELECT `uid`, MAX(`endtime`) AS `maxendtime` FROM `tt_content` GROUP BY `endtime`
     * @return array<array<mixed>>
     * @throws Exception
     */
    public function findDistinctiveEndtimeValues(): array
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLE_NAME);
        $result = $queryBuilder
            ->select('uid')
            ->addSelectLiteral(
                $queryBuilder->expr()->max('endtime', 'maxendtime'),
            )
            ->from('tt_content')
            ->groupBy('endtime')
            ->executeQuery()
            ->fetchAllAssociative()
        ;
        return $result;
    }
}
