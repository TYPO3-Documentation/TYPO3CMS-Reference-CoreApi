<?php

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Post extends AbstractEntity
{
    /**
     * @var ObjectStorage<Comment>
     */
    public ObjectStorage $comments;
}
