<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;

final class MyTableRepository
{
    public function __construct(
        private readonly Connection $connection,
    ) {}

    public function findSomething()
    {
        // Here you can use $this->connection directly
    }
}
