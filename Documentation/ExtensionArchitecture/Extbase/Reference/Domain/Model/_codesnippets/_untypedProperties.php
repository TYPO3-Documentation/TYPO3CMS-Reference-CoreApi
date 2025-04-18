<?php

declare(strict_types=1);

namespace Vendor\Extension\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Blog extends AbstractEntity
{
    /**
     * Typed property (preferred)
     *
     * @var string
     */
    protected string $title;

    /**
     * Untyped property (legacy-compatible)
     *
     * @var bool
     */
    protected $published;

    // Getters and Setters
}
