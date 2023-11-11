<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes;

use TYPO3\CMS\Core\Resource\Exception\InsufficientFolderAccessPermissionsException;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\Folder;
use TYPO3\CMS\Core\Resource\InaccessibleFolder;
use TYPO3\CMS\Core\Resource\StorageRepository;

final class MyClass
{
    private StorageRepository $storageRepository;

    public function __construct(StorageRepository $storageRepository)
    {
        $this->storageRepository = $storageRepository;
    }

    public function doSomething(): void
    {
        $defaultStorage = $this->storageRepository->getDefaultStorage();

        try {
            /** @var Folder|InaccessibleFolder $folder */
            $folder = $defaultStorage->getFolder('/some/path/in/storage/');

            /** @var File|null $file */
            $file = $folder->getFile('filename.ext');
        } catch (InsufficientFolderAccessPermissionsException $e) {
            // ... do some exception handling
        }

        // ... more logic
    }
}
