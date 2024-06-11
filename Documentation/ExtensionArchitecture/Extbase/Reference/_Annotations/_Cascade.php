<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

final class Blog extends AbstractEntity
{
    /**
     * @var ObjectStorage<Post>
     */
    #[Cascade(['value' => 'remove'])]
    public $posts;

    /**
     * Use annotations instead for compatibility with TYPO3 v11:
     *
     * @var ObjectStorage<Post>
     * @Cascade("remove")
     */
    public $posts2;
}
