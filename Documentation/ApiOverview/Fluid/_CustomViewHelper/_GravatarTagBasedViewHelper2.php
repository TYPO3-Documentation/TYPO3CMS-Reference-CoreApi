<?php

declare(strict_types=1);

namespace MyVendor\BlogExample\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

final class GravatarViewHelper extends AbstractTagBasedViewHelper
{
    protected $tagName = 'img';

    public function initializeArguments(): void
    {
        $this->registerArgument('emailAddress', 'string', 'The email address to resolve the gravatar for', false, null);
    }

    public function render(): string
    {
        $emailAddress = $this->arguments['emailAddress'] ?? $this->renderChildren();

        $this->tag->addAttribute(
            'src',
            'https://www.gravatar.com/avatar/' . md5($emailAddress),
        );

        return $this->tag->render();
    }
}
