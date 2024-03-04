<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\ContentObject\Event\ModifyRecordsAfterFetchingContentEvent;

#[AsEventListener(
    identifier: 'my-extension/my-event-listener',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyRecordsAfterFetchingContentEvent $event): void
    {
        if ($event->getConfiguration()['table'] !== 'tt_content') {
            return;
        }

        $records = array_reverse($event->getRecords());
        $event->setRecords($records);
    }
}
