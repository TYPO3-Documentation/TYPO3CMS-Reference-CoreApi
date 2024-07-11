<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Routing;

use TYPO3\CMS\Core\Routing\Aspect\MappableAspectInterface;
use TYPO3\CMS\Core\Routing\Aspect\UnresolvedValueInterface;
use TYPO3\CMS\Core\Routing\Aspect\UnresolvedValueTrait;

final class MyCustomEnhancer implements MappableAspectInterface, UnresolvedValueInterface
{
    use UnresolvedValueTrait;

    public function generate(string $value): ?string
    {
        // TODO: Implement generate() method.
    }

    public function resolve(string $value): ?string
    {
        // TODO: Implement resolve() method.
    }
}
