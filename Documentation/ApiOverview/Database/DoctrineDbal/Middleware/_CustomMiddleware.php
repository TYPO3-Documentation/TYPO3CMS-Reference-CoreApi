<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\DoctrineDBAL;

use Doctrine\DBAL\Driver as DoctrineDriverInterface;
use Doctrine\DBAL\Driver\Middleware as DoctrineDriverMiddlewareInterface;
use MyVendor\MyExtension\DoctrineDBAL\CustomDriver as MyCustomDriver;
use TYPO3\CMS\Core\Database\Middleware\UsableForConnectionInterface;

final class CustomMiddleware implements DoctrineDriverMiddlewareInterface, UsableForConnectionInterface
{
    public function wrap(DoctrineDriverInterface $driver): DoctrineDriverInterface
    {
        // Wrap the original or already wrapped driver with our custom driver
        // decoration class to provide additional features.
        return new MyCustomDriver($driver);
    }

    public function canBeUsedForConnection(
        string $identifier,
        array $connectionParams,
    ): bool {
        // Only use this driver middleware, if the configured connection driver
        // is 'pdo_sqlite' (sqlite using php-ext PDO).
        return ($connectionParams['driver'] ?? '') === 'pdo_sqlite';
    }
}
