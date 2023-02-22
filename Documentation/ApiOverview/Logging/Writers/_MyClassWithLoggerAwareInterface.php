<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

final class MyClass implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function doSomething()
    {
        $this->logger->info('My class is executed.');

        $error = false;

        // ... something is done ...

        if ($error) {
            $this->logger->error('Error in class MyClass');
        }
    }
}
