<?php
declare(strict_types=1);

namespace MyVendor\MyExtension\Backend;

/**
 * File EXT:my_extension/Classes/Backend/MyBackendClass.php
 */
final class MyBackendClass
{
    private function translateSomething(string $lll): string
    {
        return $GLOBALS['LANG']->sL($lll);
    }

    // ...
}