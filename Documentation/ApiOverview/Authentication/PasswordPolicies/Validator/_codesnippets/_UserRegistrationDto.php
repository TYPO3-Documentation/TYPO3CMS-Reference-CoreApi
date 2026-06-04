<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model\Dto;

use MyVendor\MyExtension\Domain\Validator\ExtbasePasswordPolicyValidator;
use TYPO3\CMS\Extbase\Attribute\Validate;

class UserRegistrationDto
{
    #[Validate(ExtbasePasswordPolicyValidator::class)]
    public string $plainTextPassword = '';
    // Another validator for username
    public string $username = '';
}
