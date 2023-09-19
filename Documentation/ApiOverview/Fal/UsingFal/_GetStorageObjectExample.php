<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Resource\StorageRepository;

class GetStorageObjectExample
{
    public function __construct(
        private readonly StorageRepository $storageRepository
    ) {}

    public function doSomething(): void
    {
        $storage = $this->storageRepository->getStorageObject(3);

        // .. more logic
    }
}
