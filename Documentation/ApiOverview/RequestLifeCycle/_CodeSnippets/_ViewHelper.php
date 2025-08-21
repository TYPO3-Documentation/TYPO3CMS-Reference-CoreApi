<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\ViewHelpers;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

final class MyViewHelper extends AbstractViewHelper
{
    public function render(): string
    {
        $request = $this->getRequest();
        return $request !== null ? 'Request found' : 'No request found';
    }

    private function getRequest(): ServerRequestInterface|null
    {
        if ($this->renderingContext->hasAttribute(ServerRequestInterface::class)) {
            return $this->renderingContext->getAttribute(ServerRequestInterface::class);
        }
        return null;
    }
}
