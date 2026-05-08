<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use MyVendor\MyExtension\Domain\Model\Event;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class EventRepository extends Repository
{
    protected $defaultOrderings = [
        'eventDate' => QueryInterface::ORDER_ASCENDING,
    ];

    /** @return QueryResultInterface<Event> */
    public function findUpcoming(): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->greaterThanOrEqual('eventDate', new \DateTimeImmutable('today')),
        );
        return $query->execute();
    }

    /** @return QueryResultInterface<Event> */
    public function findByTitleContaining(string $search): QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->like('title', '%' . $search . '%'),
        );
        $query->setOrderings(['title' => QueryInterface::ORDER_ASCENDING]);
        return $query->execute();
    }
}
