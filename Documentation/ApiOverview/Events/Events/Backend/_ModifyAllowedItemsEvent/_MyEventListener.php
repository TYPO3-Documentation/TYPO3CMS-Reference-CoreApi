<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\ModifyAllowedItemsEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/backend/allowed-items',
)]
final readonly class MyEventListener
{
    public function __invoke(ModifyAllowedItemsEvent $event): void
    {
        $event->addAllowedItem('someItem');
        $event->removeAllowedItem('anotherItem');
    }
}
