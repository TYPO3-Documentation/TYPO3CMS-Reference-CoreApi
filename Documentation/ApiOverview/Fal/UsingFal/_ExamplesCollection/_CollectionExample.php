<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Resource\ResourceFactory;

final class CollectionExample
{
    private ResourceFactory $resourceFactory;

    public function __construct(ResourceFactory $resourceFactory) {
        $this->resourceFactory = $resourceFactory;
    }

    public function doSomething(): void
    {
        // Get collection with uid 1
        $collection = $this->resourceFactory->getCollectionObject(1);

        // Load the contents of the collection
        $collection->loadContents();
    }
}
