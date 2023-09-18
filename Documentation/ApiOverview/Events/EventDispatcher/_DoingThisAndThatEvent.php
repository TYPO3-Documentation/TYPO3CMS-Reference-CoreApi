<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Event;

final class DoingThisAndThatEvent
{
    public function __construct(
        private string $mutableProperty,
        private readonly int $immutableProperty,
    ) {}

    public function getMutableProperty(): string
    {
        return $this->mutableProperty;
    }

    public function setMutableProperty(string $mutableProperty): void
    {
        $this->mutableProperty = $mutableProperty;
    }

    public function getImmutableProperty(): int
    {
        return $this->immutableProperty;
    }
}
