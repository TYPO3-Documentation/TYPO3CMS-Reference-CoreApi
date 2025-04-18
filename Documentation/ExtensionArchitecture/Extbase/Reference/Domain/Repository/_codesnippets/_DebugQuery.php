<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

final class MyRepository extends Repository
{
    public function findBySomething(string $something, bool $debugOn = false): QueryResultInterface
    {
        $query = $this->createQuery();
        $query = $query->matching($query->equals('some_field', $something));

        if ($debugOn) {
            $typo3DbQueryParser = GeneralUtility::makeInstance(Typo3DbQueryParser::class);
            $queryBuilder = $typo3DbQueryParser->convertQueryToDoctrineQueryBuilder($query);
            DebuggerUtility::var_dump($queryBuilder->getSQL());
            DebuggerUtility::var_dump($queryBuilder->getParameters());
        }

        return $query->execute();
    }
}
