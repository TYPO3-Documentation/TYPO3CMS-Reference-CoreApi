<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Type\Enumeration;

final class VersionState extends Enumeration
{
    public const __default = self::DEFAULT_STATE;
    public const DEFAULT_STATE = 0;
    public const NEW_PLACEHOLDER = 1;
    public const DELETE_PLACEHOLDER = 2;

    /**
     * @return bool
     */
    public function indicatesPlaceholder(): bool
    {
        return (int)$this->__toString() > self::DEFAULT_STATE;
    }
}
