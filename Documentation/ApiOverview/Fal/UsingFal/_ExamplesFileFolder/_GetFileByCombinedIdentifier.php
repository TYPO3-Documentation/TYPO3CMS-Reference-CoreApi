<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\ProcessedFile;
use TYPO3\CMS\Core\Resource\ResourceFactory;

final class MyClass
{
    public function __construct(
        private readonly ResourceFactory $resourceFactory,
    ) {}

    public function doSomething(): void
    {
        // Get the file object by combined identifier "1:/foo.txt"
        /** @var File|ProcessedFile|null $file */
        $file = $this->resourceFactory->getFileObjectFromCombinedIdentifier('1:/foo.txt');

        // ... more logic
    }
}
