<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\ViewHelpers;

final class GravatarViewHelper extends \AbstractTagBasedViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('emailAddress', 'string', 'The email address to resolve the gravatar for', true);
        $this->registerArgument('size', 'integer', 'The size of the gravatar, ranging from 1 to 512', false, 80);
    }

    public function render(): string
    {
        $this->tag->addAttribute(
            'src',
            'http://www.gravatar.com/avatar/' .
            md5($this->arguments['emailAddress']) .
            '?s=' . urlencode($this->arguments['size']),
        );
        return $this->tag->render();
    }
}
