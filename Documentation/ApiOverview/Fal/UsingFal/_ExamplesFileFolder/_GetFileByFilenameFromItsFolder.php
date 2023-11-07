<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes;

use TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\Folder;
use TYPO3\CMS\Core\Resource\InaccessibleFolder;
use TYPO3\CMS\Core\Resource\ProcessedFile;
use TYPO3\CMS\Core\Resource\StorageRepository;

final class MyClass
{
    public function __construct(
        private readonly StorageRepository $storageRepository,
    ) {}

    public function doSomething(): void
    {
        $defaultStorage = $this->storageRepository->getDefaultStorage();

        try {
            /** @var Folder|InaccessibleFolder $folder */
            $folder = $defaultStorage->getFolder('/some/path/in/storage/');

            /** @var File|ProcessedFile|null $file */
            $file = $folder->getStorage()->getFileInFolder('example.ext', $folder);
        } catch (InsufficientFolderAccessPermissionsException $e) {
            // ... do some exception handling
        }

        // ... more logic
    }
}
