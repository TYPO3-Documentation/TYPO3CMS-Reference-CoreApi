<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Repository;

use TYPO3\CMS\Core\Database\Connection;

final class MyTableRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findSomething()
    {
        // Here you can use $this->connection directly
    }
}
