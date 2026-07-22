<?php

declare(strict_types=1);

namespace Vendor\Extension\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class StringExample extends AbstractEntity
{
    #[Validate(
        validator: 'StringLength',
        options: ['maximum' => 255],
    )]
    protected string $title = '';

    public ?string $subtitle = null;

    protected string $description = '';

    protected string $icon = 'fa-solid fa-star';

    #[Validate(validator: 'MyColorValidator')]
    protected string $color = '#ffffff';

    #[Validate(validator: 'EmailAddress')]
    protected string $email = '';

    protected string $passwordHash = '';

    #[Validate(
        validator: 'StringLength',
        options: ['maximum' => 255],
    )]
    protected string $virtualValue = '';
}
