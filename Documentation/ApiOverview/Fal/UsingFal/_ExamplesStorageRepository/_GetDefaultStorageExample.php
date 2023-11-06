<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes\Resource;

use TYPO3\CMS\Core\Resource\ResourceStorage;
use TYPO3\CMS\Core\Resource\StorageRepository;

final class GetDefaultStorageExample
{
    public function __construct(
        private readonly StorageRepository $storageRepository,
    ) {}

    public function doSomething(): void
    {
        $defaultStorage = $this->storageRepository->getDefaultStorage();

        // getDefaultStorage() may return null, if no default storage is configured.
        // Therefore, we check if we receive a ResourceStorage object
        if ($defaultStorage instanceof ResourceStorage) {
            // ... do something with the default storage
        }

        // ... more logic
    }
}
