<?php

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class ConferenceRepository extends Repository
{
    public function findPublished(bool $debug = false): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching($query->equals('published', true));

        if ($debug) {
            $parser = GeneralUtility::makeInstance(Typo3DbQueryParser::class);
            $queryBuilder = $parser->convertQueryToDoctrineQueryBuilder($query);
            DebuggerUtility::var_dump($queryBuilder->getSQL());
            DebuggerUtility::var_dump($queryBuilder->getParameters());
        }

        return $query->execute();
    }
}
