<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes\Resource;

use TYPO3\CMS\Core\Resource\StorageRepository;

final class GetStorageObjectExample
{
    private StorageRepository $storageRepository;

    public function __construct(StorageRepository $storageRepository) {
        $this->storageRepository = $storageRepository;
    }

    public function doSomething(): void
    {
        $storage = $this->storageRepository->getStorageObject(3);

        // ... more logic
    }
}
