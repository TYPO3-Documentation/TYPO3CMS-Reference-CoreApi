<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Registry;

final class MyClass
{
    public function __construct(
        private readonly Registry $registry,
    ) {}

    public function doSomething()
    {
        // Use $this->registry
    }
}
