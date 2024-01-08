<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\DoctrineDBAL;

use Doctrine\DBAL\Driver\Connection as DriverConnection;
// Using the abstract class minimize the methods to implement and therefore
// reduces a lot of boilerplate code. Override only methods that needed to be
// customized.
use Doctrine\DBAL\Driver\Middleware\AbstractDriverMiddleware;

final class CustomDriver extends AbstractDriverMiddleware
{
    public function connect(#[\SensitiveParameter] array $params): DriverConnection
    {
        $connection = parent::connect($params);

        // Do something custom on connect, for example wrapping the driver
        // connection class or executing some queries on connect.

        return $connection;
    }
}
