<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Classes\DataHandling;

use TYPO3\CMS\Core\DataHandling\DataHandler;

final class MyClass
{
    private DataHandler $dataHandler;

    public function __construct(DataHandler $dataHandler)
    {
        $this->dataHandler = $dataHandler;
    }

    public function clearCache(): void
    {
        $this->dataHandler->start([], []);
        $this->dataHandler->clear_cacheCmd('all');
    }
}
