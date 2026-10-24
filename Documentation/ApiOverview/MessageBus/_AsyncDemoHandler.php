<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Queue\Handler;

use MyVendor\MyExtension\Queue\Message\DemoMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

// Runs only for messages that a worker received from "doctrine"
#[AsMessageHandler(fromTransport: 'doctrine')]
final class AsyncDemoHandler
{
  public function __invoke(DemoMessage $message): void
  {
    // do something with $message
  }
}
