<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\ModifyAllowedItemsEvent;

final class MyEventListener
{
    public function __invoke(ModifyAllowedItemsEvent $event): void
    {
        $event->addAllowedItem('someItem');
        $event->removeAllowedItem('anotherItem');
    }
}
