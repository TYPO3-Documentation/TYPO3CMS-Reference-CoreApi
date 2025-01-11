<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\AfterPageTreeItemsPreparedEvent;
use TYPO3\CMS\Backend\Dto\Tree\Label\Label;
use TYPO3\CMS\Backend\Dto\Tree\Status\StatusInformation;
use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;

#[AsEventListener(
    identifier: 'my-extension/backend/modify-page-tree-items',
)]
final readonly class MyEventListener
{
    public function __invoke(AfterPageTreeItemsPreparedEvent $event): void
    {
        $items = $event->getItems();
        foreach ($items as &$item) {
            if (($item['_page']['pid'] ?? null) === 123) {
                // Set special icon for page with ID 123
                $item['icon'] = 'my-special-icon';

                // Set a tree node label
                $item['labels'][] = new Label(
                    label: 'Campaign B',
                    color: '#00658f',
                    priority: 1,
                );

                // Set a status information
                $item['statusInformation'][] = new StatusInformation(
                    label: 'A warning message',
                    severity: ContextualFeedbackSeverity::WARNING,
                    priority: 0,
                    icon: 'actions-dot',
                    overlayIcon: '',
                );
            }
        }
        $event->setItems($items);
    }
}
