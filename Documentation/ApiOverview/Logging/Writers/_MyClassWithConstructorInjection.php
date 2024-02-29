<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use Psr\Log\LoggerInterface;

final class MyClass
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {}

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
