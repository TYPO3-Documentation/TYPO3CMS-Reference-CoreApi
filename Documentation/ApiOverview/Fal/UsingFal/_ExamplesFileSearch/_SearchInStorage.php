<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes;

use TYPO3\CMS\Core\Resource\Search\FileSearchDemand;
use TYPO3\CMS\Core\Resource\StorageRepository;

final class SearchInStorageExample
{
    public function __construct(
        private readonly StorageRepository $storageRepository,
    ) {}

    public function search($searchWord): void
    {
        $storage = $this->storageRepository->getDefaultStorage();

        $searchDemand = FileSearchDemand::createForSearchTerm($searchWord)->withRecursive();
        $files = $storage->searchFiles($searchDemand);

        // ... more logic
    }
}
