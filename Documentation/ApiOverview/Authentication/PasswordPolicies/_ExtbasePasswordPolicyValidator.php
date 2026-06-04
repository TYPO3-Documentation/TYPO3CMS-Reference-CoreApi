<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Validator;

use TYPO3\CMS\Core\PasswordPolicy\PasswordPolicyAction;
use TYPO3\CMS\Core\PasswordPolicy\PasswordPolicyValidator;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class ExtbasePasswordPolicyValidator extends AbstractValidator
{
    protected function isValid(mixed $value): void
    {
        if (!is_string($value)) {
            return;
        }
        $passwordValidator = new PasswordPolicyValidator(PasswordPolicyAction::NEW_USER_PASSWORD);
        if (!$passwordValidator->isValidPassword($value)) {
            foreach ($passwordValidator->getValidationErrors() as $validationError) {
                $this->addError($validationError, 1774872344835);
            }
        }
    }
}
