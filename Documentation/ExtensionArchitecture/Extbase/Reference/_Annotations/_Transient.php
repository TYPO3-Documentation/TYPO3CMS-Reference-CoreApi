<?php

declare(strict_types=1);
namespace T3docs\BlogExample\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\ORM\Transient;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

final class Person extends AbstractEntity
{
    #[Transient()]
    protected string $fullname = '';
    /**
     * Use annotations instead for compatibility with TYPO3 v11 and PHP 7.4:
     * @Transient
     */
    protected string $fullname2 = '';
}
