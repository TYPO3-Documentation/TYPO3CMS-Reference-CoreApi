<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Domain\Model;

use T3docs\BlogExample\Domain\Validator\TitleValidator;
use TYPO3\CMS\Extbase\Attribute\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Blog extends AbstractEntity
{
    #[Validate(
        validator: TitleValidator::class,
    )]
    public string $title = '';
}
