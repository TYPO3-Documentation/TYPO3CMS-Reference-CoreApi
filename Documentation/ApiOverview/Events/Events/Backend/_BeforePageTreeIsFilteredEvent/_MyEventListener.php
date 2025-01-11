<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Backend\Tree\Repository\BeforePageTreeIsFilteredEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Database\Connection;

final class MyEventListener
{
    #[AsEventListener]
    public function removeFetchedPageContent(BeforePageTreeIsFilteredEvent $event): void
    {
        // Adds another uid to the filter
        $event->searchUids[] = 123;

        // Adds evaluation of doktypes to the filter
        if (preg_match('/doktype:([0-9]+)/i', $event->searchPhrase, $match)) {
            $doktype = $match[1];
            $event->searchParts = $event->searchParts->with(
                $event->queryBuilder->expr()->eq('doktype',
                    $event->queryBuilder->createNamedParameter($doktype, Connection::PARAM_INT)
                )
            );
        }
    }
}
