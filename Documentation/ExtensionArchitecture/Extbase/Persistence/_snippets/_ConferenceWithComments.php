<?php

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Conference extends AbstractEntity
{
    /** @var ObjectStorage<Comment> */
    protected ObjectStorage $comments;

    /** @var ObjectStorage<Speaker> */
    protected ObjectStorage $speakers;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->comments = new ObjectStorage();
        $this->speakers = new ObjectStorage();
    }

    /** @return ObjectStorage<Comment> */
    public function getComments(): ObjectStorage
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): void
    {
        $this->comments->attach($comment);
    }

    public function removeComment(Comment $comment): void
    {
        $this->comments->detach($comment);
    }
}
