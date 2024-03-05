<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\AfterPageTreeItemsPreparedEvent;
use TYPO3\CMS\Backend\Dto\Tree\Label\Label;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/backend/modify-page-tree-items',
)]
final class MyEventListener
{
    public function __invoke(AfterPageTreeItemsPreparedEvent $event): void
    {
        $items = $event->getItems();
        foreach ($items as &$item) {
            // Set special icon for page with ID 123
            if ($item['_page']['uid'] === 123) {
                $item['icon'] = 'my-special-icon';

                // Set a tree node label
                $item['labels'][] = new Label(
                    'Campaign B', // Label
                    '#00658f', // Color as RGB value
                    1, // Priority
                );
            }
        }
        $event->setItems($items);
    }
}
