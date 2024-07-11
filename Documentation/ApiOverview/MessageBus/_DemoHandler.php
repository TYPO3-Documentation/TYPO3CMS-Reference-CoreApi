<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Queue\Handler;

use MyVendor\MyExtension\Queue\Message\DemoMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DemoHandler
{
    public function __invoke(DemoMessage $message): void
    {
        // do something with $message
    }
}
