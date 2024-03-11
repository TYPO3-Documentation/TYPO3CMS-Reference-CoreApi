<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Registry;

final class MyClass
{
    private Registry $registry;

    public function __construct(Registry $registry) {
        $this->registry = $registry;
    }

    // ... some method which calls retrieveFromRegistry()

    private function retrieveFromRegistry(): ?array
    {
        return $this->registry->get(
            'tx_myextension',
            'lastRun',
        );
    }
}
