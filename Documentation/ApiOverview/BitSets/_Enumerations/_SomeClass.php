<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use MyVendor\MyExtension\Enumerations\LikeWildcard;

final class SomeClass
{
    public function doSomething()
    {
        // ...

        $likeWildcardLeft = LikeWildcard::cast(LikeWildcard::LEFT);

        $valueFromDatabase = 1;

        // will cast the value automatically to an enumeration.
        // Result is true.
        $likeWildcardLeft->equals($valueFromDatabase);

        $enumerationWithValueFromDb = LikeWildcard::cast($valueFromDatabase);

        // Remember to always use ::cast and never use the constant directly
        $enumerationWithValueFromDb->equals(LikeWildcard::cast(LikeWildcard::RIGHT));

        // ...
    }

    // ...
}
