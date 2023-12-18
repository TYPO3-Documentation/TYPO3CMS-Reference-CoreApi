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
        $showHiddenPages = $this->context->getPropertyFromAspect(
            'visibility',
            'includeHiddenPages'
        );

        // ... do something with $showHiddenPages
    }
}
