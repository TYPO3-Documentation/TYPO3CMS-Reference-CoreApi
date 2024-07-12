<?php

declare(strict_types=1);

namespace T3docs\BlogExample\Domain\Model;

use TYPO3\CMS\Extbase\Annotation\Validate;
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
    /**
     * Use annotations instead for compatibility with TYPO3 v11 and PHP 7.4:
     * @Validate("EmailAddress")
     */
    protected string $email2 = '';

    #[Validate([
        'validator' => 'StringLength',
        'options' => [
            'maximum' => 80,
            'message' => 'A custom, non translatable message',
        ],
    ])]
    protected string $firstname = '';
    /**
     * Use annotations instead for compatibility with TYPO3 v11 and PHP 7.4:
     * @Validate("StringLength", options={"maximum": 80})
     */
    protected string $firstname2 = '';

    #[Validate([
        'validator' => 'StringLength',
        'options' => ['minimum' => 2, 'maximum' => 150],
    ])]
    protected string $lastname = '';
}
