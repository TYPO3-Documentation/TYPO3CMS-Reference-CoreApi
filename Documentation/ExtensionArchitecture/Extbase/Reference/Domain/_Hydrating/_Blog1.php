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
        $this->posts = new ObjectStorage();
    }
}
