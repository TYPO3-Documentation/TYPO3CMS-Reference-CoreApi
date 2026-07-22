<?php

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ConferenceRepository extends Repository
{
    public function findEverywhere(): QueryResultInterface
    {
        $query = $this->createQuery();
        // Search the whole table, ignoring the configured storage page
        $query->getQuerySettings()->setRespectStoragePage(false);
        return $query->execute();
    }
}
