<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Post extends AbstractEntity
{
    #[Lazy()]
    #[Cascade(['value' => 'remove'])]
    /**
     * @var ObjectStorage<Comment>
     */
    public ObjectStorage $comments;
}
