<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Resource\ResourceFactory;

final class CollectionExample
{
    public function __construct(
        private readonly ResourceFactory $resourceFactory,
    ) {}

    public function doSomething(): void
    {
        // Get collection with uid 1
        $collection = $this->resourceFactory->getCollectionObject(1);

        // Load the contents of the collection
        $collection->loadContents();
    }
}
