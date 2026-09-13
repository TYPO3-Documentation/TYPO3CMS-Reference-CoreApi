<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\LimitToTablesRestrictionContainer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final readonly class ContentDbalRepository
{
    public function __construct(
        private ConnectionPool $connectionPool,
    ) {}

    public function findWithCategories(int $id): void
    {
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()
            ->removeByType(HiddenRestriction::class)
            ->add(
                GeneralUtility::makeInstance(
                    LimitToTablesRestrictionContainer::class,
                )->addForTables(
                    GeneralUtility::makeInstance(HiddenRestriction::class),
                    ['tt'],
                ),
            );
        $queryBuilder->select('tt.uid', 'tt.header', 'sc.title')
            ->from('tt_content', 'tt')
            ->from('sys_category', 'sc')
            ->from('sys_category_record_mm', 'scmm')
            ->where(
                $queryBuilder->expr()->eq(
                    'scmm.uid_foreign',
                    $queryBuilder->quoteIdentifier('tt.uid'),
                ),
                $queryBuilder->expr()->eq(
                    'scmm.uid_local',
                    $queryBuilder->quoteIdentifier('sc.uid'),
                ),
                $queryBuilder->expr()->eq(
                    'tt.uid',
                    $queryBuilder->createNamedParameter(
                        $id,
                        Connection::PARAM_INT,
                    ),
                ),
            );
    }
}
