<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Extbase\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Extbase\Event\Persistence\ModifyQueryBeforeFetchingObjectDataEvent;

#[AsEventListener(
    identifier: 'my-extension/disabled-respect-storage-page',
)]
final readonly class DisableRespectStoragePage
{
    private const TYPES = [
        \MyVendor\MyExtension\Domain\Model\List\MyRecord::class,
        \MyVendor\MyExtension\Domain\Model\Show\MyRecord::class,
    ];

    public function __invoke(ModifyQueryBeforeFetchingObjectDataEvent $event): void
    {
        // Only apply it to the given types (models)
        if (! \in_array($event->getQuery()->getType(), self::TYPES, true)) {
            return;
        }

        $querySettings = $event->getQuery()->getQuerySettings();
        $querySettings->setRespectStoragePage(false);
    }
}
