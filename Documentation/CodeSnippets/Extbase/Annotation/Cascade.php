<?php

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Blog extends AbstractEntity
{
    /**
     * The posts of this blog
     * @var ObjectStorage<Post>
     */
    public $posts;
}
