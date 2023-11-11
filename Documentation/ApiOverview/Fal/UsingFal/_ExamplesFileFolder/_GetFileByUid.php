<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes;

use TYPO3\CMS\Core\Resource\Exception\FileDoesNotExistException;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\ResourceFactory;

final class MyClass
{
    private ResourceFactory $resourceFactory;

    public function __construct(ResourceFactory $resourceFactory)
    {
        $this->resourceFactory = $resourceFactory;
    }

    public function doSomething(): void
    {
        // Get the file object with uid=4
        try {
            /** @var File $file */
            $file = $this->resourceFactory->getFileObject(4);
        } catch (FileDoesNotExistException $e) {
            // ... do some exception handling
        }

        // ... more logic
    }
}
