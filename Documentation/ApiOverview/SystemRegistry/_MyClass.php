<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Registry;

final class MyClass
{
    public function __construct(
        private readonly Registry $registry,
    ) {}

    // ... some method which calls retrieveFromRegistry()

    private function retrieveFromRegistry(): ?array
    {
        return $this->registry->get(
            'tx_myextension',
            'lastRun',
        );
    }
}
