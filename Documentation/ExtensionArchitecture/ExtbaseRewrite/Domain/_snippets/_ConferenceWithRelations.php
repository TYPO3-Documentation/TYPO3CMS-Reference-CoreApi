<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\ORM\Cascade;
use TYPO3\CMS\Extbase\Attribute\ORM\Lazy;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Conference extends AbstractEntity
{
    protected string $title = '';

    // a relation to one other object — a nullable typed property
    protected Location|LazyLoadingProxy|null $location = null;

    /**
     * @var ObjectStorage<Comment>
     */
    #[Lazy]
    #[Cascade('remove')]
    protected ObjectStorage $comments;

    public function __construct()
    {
        $this->initializeObject();
    }

    public function initializeObject(): void
    {
        $this->comments = new ObjectStorage();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getLocation(): ?Location
    {
        // type check only for phpstan
        if ($this->location instanceof LazyLoadingProxy) {
            $this->location = $this->location->_loadRealInstance();
        }
        return $this->location;
    }

    public function setLocation(?Location $location): void
    {
        $this->location = $location;
    }

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
