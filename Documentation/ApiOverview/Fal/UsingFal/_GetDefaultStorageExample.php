<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Resource\StorageRepository;

class GetDefaultStorageExample
{
    public function __construct(
        private readonly StorageRepository $storageRepository
    ) {}

    public function doSomething(): void
    {
        $defaultStorage = $this->storageRepository->getDefaultStorage();

        // .. more logic
    }
}
