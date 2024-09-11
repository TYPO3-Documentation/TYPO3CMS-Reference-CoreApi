<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

final class GravatarViewHelper extends AbstractTagBasedViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument(
            'emailAddress',
            'string',
            'The email address to resolve the gravatar for',
            true,
        );
        $this->registerArgument(
            'size',
            'integer',
            'The size of the gravatar, ranging from 1 to 512',
            false,
            80,
        );
    }

    public function render(): string
    {
        $emailAddress = $this->arguments['emailAddress'];
        $size = $this->arguments['size'];
        $this->tag->addAttribute(
            'src',
            sprintf(
                'http://www.gravatar.com/avatar/%s?s=%s',
                md5($emailAddress),
                urlencode($size),
            ),
        );
        return $this->tag->render();
    }
}
