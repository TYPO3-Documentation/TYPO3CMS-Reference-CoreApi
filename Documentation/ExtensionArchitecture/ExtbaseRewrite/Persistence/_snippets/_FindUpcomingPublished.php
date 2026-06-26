<?php

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ConferenceRepository extends Repository
{
    public function findUpcomingPublished(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('published', true),
                $query->greaterThanOrEqual('conferenceDate', new \DateTimeImmutable('today')),
            ),
        );
        return $query->execute();
    }
}
