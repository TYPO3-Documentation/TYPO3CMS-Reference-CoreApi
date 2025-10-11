<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Domain\Model;

use TYPO3\CMS\Extbase\Attribute\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Person extends AbstractEntity
{
    #[Validate([
        'validator' => 'EmailAddress',
        'options' => [
            'message' => 'LLL:EXT:extbase/Resources/Private/Language/locallang.xlf:validator.emailaddress.notvalid',
        ],
    ])]
    protected string $email = '';

    #[Validate([
        'validator' => 'StringLength',
        'options' => [
            'maximum' => 80,
            'message' => 'A custom, non translatable message',
        ],
    ])]
    protected string $firstname = '';

    #[Validate([
        'validator' => 'StringLength',
        'options' => ['minimum' => 2, 'maximum' => 150],
    ])]
    protected string $lastname = '';
}
