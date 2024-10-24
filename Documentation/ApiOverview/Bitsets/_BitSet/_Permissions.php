<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Bitmask;

use TYPO3\CMS\Core\Type\BitSet;

final class Permissions extends BitSet
{
    public const NONE = 0b0; // 0
    public const PAGE_SHOW = 0b1; // 1
    public const PAGE_EDIT = 0b10; // 2
    public const PAGE_DELETE = 0b100; // 4
    public const PAGE_NEW = 0b1000; // 8
    public const CONTENT_EDIT = 0b10000; // 16
    public const ALL = 0b11111; // 31

    public function hasPermission(int $permission): bool
    {
        return $this->get($permission);
    }

    public function hasAllPermissions(): bool
    {
        return $this->get(self::ALL);
    }

    public function allow(int $permission): void
    {
        $this->set($permission);
    }
}
