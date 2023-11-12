<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes;

use TYPO3\CMS\Core\Resource\Search\FileSearchDemand;
use TYPO3\CMS\Core\Resource\StorageRepository;

final class SearchInFolderExample
{
    private StorageRepository $storageRepository;

    public function __construct(StorageRepository $storageRepository) {
        $this->storageRepository = $storageRepository;
    }

    public function search($searchWord): void
    {
        $folder = $this->getFolderFromDefaultStorage('/some/path/in/storage/');

        $searchDemand = FileSearchDemand::createForSearchTerm($searchWord)->withRecursive();
        $files = $folder->searchFiles($searchDemand);

        // ... more logic
    }

    private function getFolderFromDefaultStorage(string $path)
    {
        $defaultStorage = $this->storageRepository->getDefaultStorage();

        return $defaultStorage->getFolder($path);
    }
}
