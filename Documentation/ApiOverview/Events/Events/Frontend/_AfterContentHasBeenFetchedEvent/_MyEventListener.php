<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Frontend\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Frontend\Event\AfterContentHasBeenFetchedEvent;

final readonly class MyEventListener
{
    #[AsEventListener]
    public function removeFetchedPageContent(AfterContentHasBeenFetchedEvent $event): void
    {
        foreach ($event->groupedContent as $columnIdentifier => $column) {
            foreach ($column['records'] ?? [] as $key => $record) {
                if ($record->has('parent_field_name') && (int)($record->get('parent_field_name') ?? 0) > 0) {
                    unset($event->groupedContent[$columnIdentifier]['records'][$key]);
                }
            }
        }
    }
}
