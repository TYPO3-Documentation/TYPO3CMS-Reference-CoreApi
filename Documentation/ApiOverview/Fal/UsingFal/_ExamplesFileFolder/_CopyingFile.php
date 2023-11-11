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
    public function __construct(
        private readonly StorageRepository $storageRepository,
    ) {}

    public function doSomething(): void
    {
        $storageUid = 17;
        $someFileIdentifier = 'templates/images/banner.jpg';
        $someFolderIdentifier = 'website/images/';

        $storage = $this->storageRepository->getStorageObject($storageUid);

        /** @var File $file */
        $file = $storage->getFile($someFileIdentifier);

        try {
            /** @var Folder|InaccessibleFolder $folder */
            $folder = $storage->getFolder($someFolderIdentifier);

            /** @var File $copiedFile The new, copied file */
            $copiedFile = $file->copyTo($folder);
        } catch (InsufficientFolderAccessPermissionsException|\RuntimeException $e) {
            // ... do some exception handling
        }

        // ... more logic
    }
}
