<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\DataHandling;

use TYPO3\CMS\Core\DataHandling\DataHandler;

final class MyClass
{
    public function __construct(
        private readonly DataHandler $dataHandler,
    ) {}

    public function basicUsage(): void
    {
        $cmd = [];
        $data = [];
        $this->dataHandler->start($data, $cmd);

        // ... do something more ...
    }
}
