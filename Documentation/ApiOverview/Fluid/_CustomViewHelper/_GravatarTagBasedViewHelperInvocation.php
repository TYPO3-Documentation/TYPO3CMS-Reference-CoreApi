<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

final class GravatarViewHelper extends AbstractViewHelper
{
    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('emailAddress', 'string', 'The email address to resolve the gravatar for', true);
    }

    public function render(): string
    {
        $emailAddress = $this->arguments['emailAddress'];
        $gravatarUrl = $this->renderingContext->getViewHelperInvoker()->invoke(
            GravatarUrlViewHelper::class,
            ['email', $emailAddress],
            $this->renderingContext,
            $this->renderChildren(),
        );

        return sprintf('<img src="%s" />', $gravatarUrl);
    }
}
