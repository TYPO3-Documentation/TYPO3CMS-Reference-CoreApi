<?php

final class TitleValidator extends AbstractValidator
{
    protected function isValid(mixed $value): void
    {
        // $value is the title string
        if (is_scalar($value) && str_starts_with((string)$value, '_')) {
            $errorString = 'The title may not start with an underscore. ';
            $this->addError($errorString, 1297418976);
        }
    }
}
