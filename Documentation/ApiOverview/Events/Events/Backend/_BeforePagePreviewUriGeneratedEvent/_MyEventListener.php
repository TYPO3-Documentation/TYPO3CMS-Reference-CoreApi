<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Backend\EventListener;

use TYPO3\CMS\Backend\Routing\Event\BeforePagePreviewUriGeneratedEvent;
use TYPO3\CMS\Core\Attribute\AsEventListener;

#[AsEventListener(
    identifier: 'my-extension/backend/modify-parameters',
)]
final readonly class MyEventListener
{
    public function __invoke(BeforePagePreviewUriGeneratedEvent $event): void
    {
        // Add custom query parameter before URI generation
        $event->setAdditionalQueryParameters(
            array_replace_recursive(
                $event->getAdditionalQueryParameters(),
                ['myParam' => 'paramValue'],
            ),
        );
    }
}
