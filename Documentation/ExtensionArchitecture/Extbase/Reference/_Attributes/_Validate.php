<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Blog extends AbstractEntity
{
    #[Validate([
        'validator' => 'StringLength',
        'options' => ['maximum' => 150],
    ])]
    public string $description = '';
}
