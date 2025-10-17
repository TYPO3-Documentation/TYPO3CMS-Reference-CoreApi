<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Controller\Event\AfterFileStorageTreeItemsPreparedEvent;
use TYPO3\CMS\Backend\Dto\Tree\Label\Label;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/backend/modify-file-storage-tree-items',
)]
final readonly class ModifyFileStorageTreeItems
{
    public function __invoke(AfterFileStorageTreeItemsPreparedEvent $event): void
    {
        $items = $event->getItems();
        foreach ($items as &$item) {
            // Add special label for storage with uid 1
            if ($item['resource']->getCombinedIdentifier() === '1:/campaigns/') {
                $item['labels'][] = new Label(
                    label: 'A label',
                    color: '#abcdef',
                    priority: 10,
                );
                $item['statusInformation'][] = new StatusInformation(
                    label: 'An important information',
                    severity: ContextualFeedbackSeverity::INFO,
                    priority: 10,
                    icon: 'content-info',
                );
            }
        }
        $event->setItems($items);
    }
}
