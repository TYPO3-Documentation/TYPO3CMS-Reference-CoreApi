<?php

use T3docs\BlogExample\Domain\Model\Blog;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

final class BlogValidator extends AbstractValidator
{
    protected function isValid(mixed $value): void
    {
        if (!$value instanceof Blog) {
            $errorString = 'The blog validator can only handle classes '
                . 'of type T3docs\BlogExample\Domain\Validator\Blog. '
                . $value::class . ' given instead.';
            $this->addError($errorString, 1297418975);
        }
        if (!$this->blogValidationService->isBlogCategoryCountValid($value)) {
            $errorString = LocalizationUtility::translate(
                'error.Blog.tooManyCategories',
                'BlogExample',
            );
            // Add the error to the property if it is specific to one property
            $this->addErrorForProperty('categories', $errorString, 1297418976);
        }
        if (!$this->blogValidationService->isBlogSubtitleValid($value)) {
            $errorString = LocalizationUtility::translate(
                'error.Blog.invalidSubTitle',
                'BlogExample',
            );
            // Add the error directly if it takes several properties into account
            $this->addError($errorString, 1297418974);
        }
    }
}
