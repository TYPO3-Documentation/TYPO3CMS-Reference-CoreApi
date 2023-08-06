<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Type\Enumeration;

final class VersionState extends Enumeration
{
    const __default = self::DEFAULT_STATE;
    const NEW_PLACEHOLDER_VERSION = -1;
    const DEFAULT_STATE = 0;
    const NEW_PLACEHOLDER = 1;
    const DELETE_PLACEHOLDER = 2;
    const MOVE_POINTER = 4;

    /**
     * @return bool
     */
    public function indicatesPlaceholder(): bool
    {
        return (int)$this->__toString() > self::DEFAULT_STATE;
    }
}
