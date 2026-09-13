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

    public function findPages(): array
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('pages');
        $statement = $queryBuilder
            ->select('uid')
            ->from('pages')
            ->where(
                $queryBuilder->expr()->eq(
                    'uid',
                    $queryBuilder->createPositionalParameter(
                        0,
                        Connection::PARAM_INT,
                    ),
                ),
            )
            ->prepare();

        $pages = [];
        foreach ([24, 25] as $pageId) {
            // Bind $pageId value to the first (and in this case only)
            // positional parameter
            $statement->bindValue(1, $pageId, Connection::PARAM_INT);
            $result = $statement->executeQuery();
            $pages[] = $result->fetchAssociative();
            // Free the resources for this result
            $result->free();
        }
        return $pages;
    }
}
