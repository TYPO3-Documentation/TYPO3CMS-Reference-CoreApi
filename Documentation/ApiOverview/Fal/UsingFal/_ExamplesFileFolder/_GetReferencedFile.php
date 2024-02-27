<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes;

use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\FileRepository;

final class MyClass
{
    public function __construct(
        private readonly FileRepository $fileRepository,
    ) {}

    public function doSomething(): void
    {
        /** @var FileReference[] $fileObjects */
        $fileObjects = $this->fileRepository->findByRelation('pages', 'media', 42);

        // ... more logic
    }
}
