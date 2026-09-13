<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

final class MyDbalRepository
{
    public function applyWhereExpressions(
        QueryBuilder $queryBuilder,
        bool $needsAdditionalExpression,
        string $someAdditionalExpression,
    ): void {
        $whereExpressions = [
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
        ];
        if ($needsAdditionalExpression) {
            $whereExpressions[] = $someAdditionalExpression;
        }
        $queryBuilder->where(...$whereExpressions);
    }
}
