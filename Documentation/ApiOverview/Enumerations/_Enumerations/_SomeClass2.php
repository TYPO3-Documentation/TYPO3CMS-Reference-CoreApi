<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use MyVendor\MyExtension\Enumerations\LikeWildcard;
use TYPO3\CMS\Core\Type\Exception\InvalidEnumerationValueException;

final class SomeClass
{
    public function doSomething()
    {
        // ...

        try {
            $foo = LikeWildcard::cast($valueFromPageTs);
        } catch (InvalidEnumerationValueException $exception) {
            $foo = LikeWildcard::cast(LikeWildcard::NONE);
        }

        // ...
    }

    // ...
}
