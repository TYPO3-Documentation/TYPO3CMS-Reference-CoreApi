<?php

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ConferenceRepository extends Repository
{
    public function findPublished(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('published', true),
        );
        return $query->execute();
    }
}
