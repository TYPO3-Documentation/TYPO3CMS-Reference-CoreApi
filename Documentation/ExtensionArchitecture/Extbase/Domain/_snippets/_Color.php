<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

final class Color
{
  public function __construct(
    public readonly string $name,
    public readonly string $hex,
  ) {
    if (!preg_match('/^#[0-9a-fA-F]{6}$/', $hex)) {
      throw new \InvalidArgumentException('Invalid hex color: ' . $hex);
    }
  }

  public function equals(self $other): bool
  {
    return $this->hex === $other->hex;
  }

  public function withName(string $name): self
  {
    return new self($name, $this->hex);
  }
}
