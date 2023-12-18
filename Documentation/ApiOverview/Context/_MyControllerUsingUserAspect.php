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
        $userIsLoggedIn = $this->context->getPropertyFromAspect(
            'frontend.user',
            'isLoggedIn'
        );

        // ... do something with $userIsLoggedIn
    }
}
