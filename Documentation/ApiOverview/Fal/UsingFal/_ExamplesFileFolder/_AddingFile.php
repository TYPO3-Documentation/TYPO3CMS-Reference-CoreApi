<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\StorageRepository;

final class MyClass
{
    public function __construct(
        private readonly StorageRepository $storageRepository,
    ) {}

    public function doSomething(): void
    {
        $storage = $this->storageRepository->getDefaultStorage();

        /** @var File $newFile */
        $newFile = $storage->addFile(
            '/tmp/temporary_file_name.ext',
            $storage->getRootLevelFolder(),
            'final_file_name.ext',
        );

        // ... more logic
    }
}
