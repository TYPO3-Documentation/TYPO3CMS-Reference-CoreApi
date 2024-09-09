<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

final class GravatarViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        // registerArgument($name, $type, $description, $required, $defaultValue, $escape)
        $this->registerArgument(
            'emailAddress',
            'string',
            'The email address to resolve the gravatar for',
            true,
        );
        $this->registerArgument(
            'alt',
            'string',
            'The optional alt text for the image',
        );
    }

    public function render(): string
    {
        $emailAddress = $this->arguments['emailAddress'];
        $altText = $this->arguments['alt'] ?? '';

        // this is improved with the TagBasedViewHelper (see below)
        return sprintf(
            '<img src="https://www.gravatar.com/avatar/%s" alt="%s">',
            md5($emailAddress),
            htmlspecialchars($altText),
        );
    }
}
