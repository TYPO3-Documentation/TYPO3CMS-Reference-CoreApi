<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Queue\Message;

final class DemoMessage
{
    public function __construct(
        public readonly string $content,
    ) {}
}
