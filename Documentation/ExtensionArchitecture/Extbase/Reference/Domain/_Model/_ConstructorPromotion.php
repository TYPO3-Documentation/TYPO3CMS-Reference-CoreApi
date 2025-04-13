<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Blog extends AbstractEntity
{
    // The constructor defaults are applied **only** when you create a new
    // object with $blog = new Blog();
    public function __construct(
        protected string $title = '',
        protected ?\Datetime $modified = null,
    ) {}

    // This method is called when the object is thawed (retrieved from the database)
    public function initializeObject(): void
    {
        $this->title = '';
        $this->modified = null;
    }
}
