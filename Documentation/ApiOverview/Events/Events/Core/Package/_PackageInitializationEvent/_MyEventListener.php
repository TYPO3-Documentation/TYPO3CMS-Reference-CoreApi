<?php

namespace MyVendor\MyExtension\Package\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Package\Event\PackageInitializationEvent;
use TYPO3\CMS\Core\Package\Initialization\ImportExtensionDataOnPackageInitialization;

#[AsEventListener(
    identifier: 'my-extension/package-initialization',
    after: ImportExtensionDataOnPackageInitialization::class,
)]
final readonly class MyEventListener
{
    public function __invoke(PackageInitializationEvent $event): void
    {
        if ($event->getExtensionKey() === 'my_extension') {
            $event->addStorageEntry(__CLASS__, 'my result');
        }
    }
}
