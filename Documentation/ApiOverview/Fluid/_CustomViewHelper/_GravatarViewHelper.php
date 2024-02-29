<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

final class GravatarViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    protected $escapeOutput = false;

    public function initializeArguments(): void
    {
        // registerArgument($name, $type, $description, $required, $defaultValue, $escape)
        $this->registerArgument('emailAddress', 'string', 'The email address to resolve the gravatar for', true);
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext,
    ): string {
        // this is improved with the TagBasedViewHelper (see below)
        return sprintf('<img src="https://www.gravatar.com/avatar/%s" />', md5($arguments['emailAddress']));
    }
}
