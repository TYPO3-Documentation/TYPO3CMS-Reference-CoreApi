<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes;

use TYPO3\CMS\Core\Resource\Search\FileSearchDemand;
use TYPO3\CMS\Core\Resource\StorageRepository;

final class SearchInStorageWithRestrictionsExample
{
    private StorageRepository $storageRepository;

    public function __construct(StorageRepository $storageRepository) {
        $this->storageRepository = $storageRepository;
    }

    public function search($searchWord): void
    {
        $storage = $this->storageRepository->getDefaultStorage();

        // Get the 10 biggest files in the storage
        $searchDemand = FileSearchDemand::createForSearchTerm($searchWord)
            ->withRecursive()
            ->withMaxResults(10)
            ->addOrdering('sys_file', 'size', 'DESC');
        $files = $storage->searchFiles($searchDemand);

        // ... more logic
    }
}
