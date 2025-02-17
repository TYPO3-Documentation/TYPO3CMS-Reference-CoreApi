<?php

namespace MyExtension\MyVendor\Service;

use Doctrine\DBAL\Query\UnionType;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

final readonly class MyService
{
    public function __construct(
        private ConnectionPool $connectionPool,
    ) {}

    public function getTitlesOfSubpagesAndContent(
        int $parentId,
    ): ?array {
        $connection = $this->connectionPool->getConnectionForTable('pages');
        $unionQueryBuilder = $connection->createQueryBuilder();

        // Passing the outermost QueryBuilder to the subqueries
        $firstPartQueryBuilder = $this->getUnionPart1QueryBuilder($connection, $unionQueryBuilder, $parentId);
        $secondPartQueryBuilder = $this->getUnionPart2QueryBuilder($connection, $unionQueryBuilder, $parentId);

        return $unionQueryBuilder
            ->union($firstPartQueryBuilder)
            ->addUnion($secondPartQueryBuilder, UnionType::DISTINCT)
            ->orderBy('uid', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative();
    }

    private function getUnionPart1QueryBuilder(
        Connection $connection,
        QueryBuilder $unionQueryBuilder,
        int $pageId,
    ): QueryBuilder {
        $queryBuilder = $connection->createQueryBuilder();
        // The union Expression Builder **must** be used on subqueries
        $unionExpr = $unionQueryBuilder->expr();
        $queryBuilder
            // The column names of the first query are used
            // The column count of both subqueries must be the same
            // The data types must be compatible across columns of the queries
            ->select('title', 'subtitle')
            ->from('pages')
            ->where(
                // The union Expression Builder **must** be used on subqueries
                $unionExpr->eq(
                    'pages.pid',
                    // Named parameters **must** be created on the outermost (union) query builder
                    $unionQueryBuilder->createNamedParameter($pageId, Connection::PARAM_INT),
                ),
            );
        return $queryBuilder;
    }

    private function getUnionPart2QueryBuilder(
        Connection $connection,
        QueryBuilder $unionQueryBuilder,
        int $pageId,
    ): QueryBuilder {
        $queryBuilder = $connection->createQueryBuilder();
        // The union Expression Builder **must** be used on subqueries
        $unionExpr = $unionQueryBuilder->expr();
        $queryBuilder
            // The column count of both subqueries must be the same
            ->select('header', 'subheader')
            ->from('tt_content')
            ->where(
                $unionExpr->eq(
                    'tt_content.pid',
                    // Named parameters **must** be created on the outermost (union) query builder
                    $unionQueryBuilder->createNamedParameter($pageId, Connection::PARAM_INT),
                ),
            );
        return $queryBuilder;
    }
}
