<?php

namespace MyVendor\MyExtenion\Validators;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

final class MyCustomValidator extends AbstractValidator
{
    public function __construct(private readonly Something $something) {
    }

    protected function isValid(mixed $value): void
    {
        // TODO: Implement isValid() method.
    }
}
