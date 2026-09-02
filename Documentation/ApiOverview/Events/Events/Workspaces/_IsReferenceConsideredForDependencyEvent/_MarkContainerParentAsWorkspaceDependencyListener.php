<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Workspaces\Event\IsReferenceConsideredForDependencyEvent;

#[AsEventListener(identifier: 'my-extension/mark-container-parent-as-workspace-dependency')]
final readonly class MarkContainerParentAsWorkspaceDependencyListener
{
    public function __invoke(IsReferenceConsideredForDependencyEvent $event): void
    {
        if ($event->getTableName() !== 'tt_content' || $event->getFieldName() !== 'tx_container_parent') {
            return;
        }
        $event->setDependency(true);
    }
}
