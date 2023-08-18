<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\UserFunctions;

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

final class MyClass
{
    /**
     * Reference to the parent (calling) cObject set from TypoScript
     */
    private ContentObjectRenderer $cObj;

    public function setContentObjectRenderer(ContentObjectRenderer $cObj): void
    {
        $this->cObj = $cObj;
    }

    // ... other methods
}
