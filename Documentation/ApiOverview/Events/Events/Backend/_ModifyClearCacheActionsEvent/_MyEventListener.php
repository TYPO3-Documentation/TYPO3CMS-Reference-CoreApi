<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Backend\Event\ModifyClearCacheActionsEvent;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/toolbar/my-event-listener',
)]
final readonly class MyEventListener
{
    public function __construct(private UriBuilder $uriBuilder) {}

    public function __invoke(ModifyClearCacheActionsEvent $event): void
    {
        $event->addCacheAction([
            // Required keys:
            'id' => 'pages',
            'title' => 'core.cache:group.pages.label',
            'endpoint' => (string)$this->uriBuilder->buildUriFromRoute(
                'tce_db',
                ['cacheCmd' => 'pages'],
            ),
            'iconIdentifier' => 'actions-system-cache-clear-impact-low',
            // Optional, recommended keys:
            'description' => 'core.cache:group.pages.description',
            'severity' => 'success',
        ]);
    }
}
