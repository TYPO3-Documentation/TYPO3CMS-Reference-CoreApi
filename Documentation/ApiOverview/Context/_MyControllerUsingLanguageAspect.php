<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Controller;

use TYPO3\CMS\Core\Context\Context;

final class MyController
{
    public function __construct(
        private readonly Context $context,
    ) {}

    public function doSomething(): void
    {
        $fallbackChain = $this->context->getPropertyFromAspect(
            'language',
            'fallbackChain'
        );

        // ... do something with $fallbackChain
    }
}
