<?php

namespace MyVendor\MyExtenion\Validators;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

final class MyCustomValidator extends AbstractValidator
{
    public function injectSomething(Something $something)
    {
        $this->something = $something;
    }

    public function setOptions(array $options): void
    {
        // This method is upwards compatible with TYPO3 v12, it will be implemented
        // by AbstractValidator in v12 directly and is part of v12 ValidatorInterface.
        // @todo: Remove this method when v11 compatibility is dropped.
        $this->initializeDefaultOptions($options);
    }

    protected function isValid(mixed $value): void
    {
        // TODO: Implement isValid() method.
    }
}
