<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes\DataHandling;

use TYPO3\CMS\Core\DataHandling\DataHandler;

final class MyClass
{
    public function __construct(
        private readonly DataHandler $dataHandler,
    ) {}

    public function clearCache(): void
    {
        $this->dataHandler->start([], []);
        $this->dataHandler->clear_cacheCmd('all');
    }
}
