<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\ORM\Cascade;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

final class Blog extends AbstractEntity
{
    /**
     * @var ObjectStorage<Post>
     */
    #[Cascade(value: 'remove')]
    public ObjectStorage $posts;
}
