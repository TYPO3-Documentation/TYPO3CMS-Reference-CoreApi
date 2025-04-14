<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Blog extends AbstractEntity
{
    protected ObjectStorage $posts;

    public function __construct(protected string $title)
    {
        // Property "posts" is not initialized on thawing / fetching from database!!
        // Must be initialized in initializeObject()!!
        $this->posts = new ObjectStorage();
    }
}
