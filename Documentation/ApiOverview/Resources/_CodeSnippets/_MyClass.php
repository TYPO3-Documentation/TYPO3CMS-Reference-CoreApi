<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Something;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class MyClass
{
    public function myFunction(): void
    {
        $absoluteFilePath = GeneralUtility::getFileAbsFileName(
            'EXT:my_extension/Resources/Private/SomeFile.xml',
        );
    }
}
