<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Enumerations;

use TYPO3\CMS\Core\Type\Enumeration;

final class LikeWildcard extends Enumeration
{
    public const __default = self::BOTH;

    /**
     * @var int Do not use any wildcard
     */
    public const NONE = 0;

    /**
     * @var int Use wildcard on left side
     */
    public const LEFT = 1;

    /**
     * @var int Use wildcard on right side
     */
    public const RIGHT = 2;

    /**
     * @var int Use wildcard on both sides
     */
    public const BOTH = 3;
}
