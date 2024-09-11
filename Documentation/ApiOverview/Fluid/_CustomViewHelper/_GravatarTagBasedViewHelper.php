<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

final class GravatarViewHelper extends AbstractTagBasedViewHelper
{
    protected $tagName = 'img';

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument(
            'emailAddress',
            'string',
            'The email address to resolve the gravatar for',
            true,
        );
        // The alt argument will be automatically registered
    }

    public function render(): string
    {
        $emailAddress = $this->arguments['emailAddress'];
        $this->tag->addAttribute(
            'src',
            'https://www.gravatar.com/avatar/' . md5($emailAddress),
        );
        return $this->tag->render();
    }
}
