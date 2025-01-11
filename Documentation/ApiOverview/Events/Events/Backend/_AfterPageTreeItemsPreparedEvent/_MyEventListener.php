<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\AfterPageTreeItemsPreparedEvent;

final class MyEventListener
{
    public function __invoke(AfterPageTreeItemsPreparedEvent $event): void
    {
        $items = $event->getItems();
        foreach ($items as &$item) {
            if (($item['_page']['pid'] ?? null) === 123) {
                // Set special icon for page with ID 123
                $item['icon'] = 'my-special-icon';
            }
        }
        $event->setItems($items);
    }
}
