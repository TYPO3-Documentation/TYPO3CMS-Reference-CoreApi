<?php

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ConferenceRepository extends Repository
{
    public function findAllAcrossPages(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        return $query->execute();
    }
}
