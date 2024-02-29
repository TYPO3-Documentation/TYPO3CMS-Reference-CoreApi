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
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('alt', 'string', 'Alternative text for the image');
        $this->registerArgument('emailAddress', 'string', 'The email address to resolve the gravatar for', true);
    }

    public function render(): string
    {
        $this->tag->addAttribute(
            'src',
            'https://www.gravatar.com/avatar/' . md5($this->arguments['emailAddress']),
        );
        return $this->tag->render();
    }
}
