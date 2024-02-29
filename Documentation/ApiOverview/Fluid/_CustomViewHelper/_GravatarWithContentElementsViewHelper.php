<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

final class GravatarViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('emailAddress', 'string', 'The email address to resolve the gravatar for');
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext,
    ): string {
        $emailAddress = $renderChildrenClosure();

        return sprintf('<img src="https://www.gravatar.com/avatar/%s" />', md5($emailAddress));
    }
}
