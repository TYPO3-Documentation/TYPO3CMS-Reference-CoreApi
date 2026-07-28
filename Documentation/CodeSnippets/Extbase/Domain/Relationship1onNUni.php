<?php

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Post extends AbstractEntity implements \Stringable
{
    /**
     * @var ?ObjectStorage<Comment>
     */
    public ?ObjectStorage $comments = null;
}
