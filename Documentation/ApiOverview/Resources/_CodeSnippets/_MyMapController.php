<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Something;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

class MyMapController
{
    public function getWebPath(string $path = 'EXT:my_extension/Resources/Public/myfile.xml'): string
    {
        // This only works in frontend context, not in CLI
        $absolutePath = GeneralUtility::getFileAbsFileName($path);
        return PathUtility::getAbsoluteWebPath($absolutePath);
    }
}
