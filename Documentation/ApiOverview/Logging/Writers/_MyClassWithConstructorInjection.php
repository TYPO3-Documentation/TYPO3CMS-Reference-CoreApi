<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use Psr\Log\LoggerInterface;

final class MyClass
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

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
