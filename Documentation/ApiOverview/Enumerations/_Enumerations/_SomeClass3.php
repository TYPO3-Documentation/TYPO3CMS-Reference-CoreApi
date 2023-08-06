<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

final class SomeClass
{
    public function doSomething()
    {
        // ...

        $myVersionState = VersionState::cast($versionStateValue);
        if ($myVersionState->indicatesPlaceholder()) {
            echo 'The state indicates that this is a placeholder';
        }

        // ...
    }

    // ...
}
