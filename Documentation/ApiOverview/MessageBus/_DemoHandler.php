<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Queue\Handler;

use MyVendor\MyExtension\Queue\Message\DemoMessage;

final class DemoHandler
{
    public function __invoke(DemoMessage $message): void
    {
        // do something with $message
    }
}
