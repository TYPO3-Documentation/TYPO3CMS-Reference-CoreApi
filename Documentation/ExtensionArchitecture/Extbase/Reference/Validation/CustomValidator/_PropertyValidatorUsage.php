<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Domain\Model;

use T3docs\BlogExample\Domain\Validator\TitleValidator;
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Blog extends AbstractEntity
{
    #[Validate([
        'validator' => TitleValidator::class,
    ])]
    public string $title = '';
    /**
     * Use annotations instead for compatibility with TYPO3 v11 and PHP 7.4:
     * @Validate("T3docs\BlogExample\Domain\Validator\TitleValidator")
     */
    public string $title2 = '';
}
