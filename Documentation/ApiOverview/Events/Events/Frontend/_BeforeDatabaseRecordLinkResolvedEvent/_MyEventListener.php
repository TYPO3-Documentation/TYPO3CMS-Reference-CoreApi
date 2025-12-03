<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\Event\BeforeDatabaseRecordLinkResolvedEvent;

final readonly class MyEventListener
{
    #[AsEventListener(
        identifier: 'my-extension/before-database-record-link-resolved',
    )]
    public function __invoke(BeforeDatabaseRecordLinkResolvedEvent $event): void
    {
        // Retrieve the record from the database as an array (just an example -
        // replace the code in the first line below with your code)
        $result = getADatabaseRecord();
        if ($result !== false) {
            // Setting the record stops event propagation and
            // skips the default record retrieval logic
            $event->record = $result;
        }
    }
}
