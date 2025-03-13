<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Validators;

use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

final class MyCustomValidator extends AbstractValidator
{
    protected function isValid(mixed $value): void
    {
        /** @var ?Site $site */
        $site = $this->getRequest()?->getAttribute('site');
        $siteSettings = $site?->getSettings() ?? [];
        // TODO: Implement isValid() method using site settings
    }
}
