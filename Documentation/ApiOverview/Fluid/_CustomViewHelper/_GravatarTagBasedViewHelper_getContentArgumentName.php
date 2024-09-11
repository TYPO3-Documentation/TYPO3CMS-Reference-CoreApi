<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

final class GravatarViewHelper extends AbstractTagBasedViewHelper
{
    protected $tagName = 'img';

    public function initializeArguments(): void
    {
        $this->registerArgument(
            'emailAddress',
            'string',
            'The email address to resolve the gravatar for',
            // The argument is optional now
        );
    }

    public function render(): string
    {
        $emailAddress = $this->renderChildren();

        // The children of the ViewHelper might be empty now
        if ($emailAddress === null) {
            throw new \Exception(
                'The Gravatar ViewHelper expects either the '
                . 'argument "emailAddress" or the content to be set. ',
                1726035545,
            );
        }
        // Or someone could pass a non-string value
        if (!is_string($emailAddress) || !filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception(
                'The Gravatar ViewHelper expects a valid ' .
                'e-mail address as input. ',
                1726035546,
            );
        }

        $this->tag->addAttribute(
            'src',
            'https://www.gravatar.com/avatar/' . md5($emailAddress),
        );

        return $this->tag->render();
    }

    public function getContentArgumentName(): string
    {
        return 'emailAddress';
    }
}
