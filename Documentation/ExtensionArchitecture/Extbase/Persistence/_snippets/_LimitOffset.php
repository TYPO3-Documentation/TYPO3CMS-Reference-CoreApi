<?php

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ConferenceRepository extends Repository
{
    public function findSlice(int $limit, int $offset = 0): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->setLimit($limit);
        $query->setOffset($offset);
        return $query->execute();
    }
}
