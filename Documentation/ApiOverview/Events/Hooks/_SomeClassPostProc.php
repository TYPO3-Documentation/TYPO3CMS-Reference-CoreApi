<?php

declare(strict_types=1);

namespace MyVendor\MyExtension;

use TYPO3\CMS\Core\Utility\GeneralUtility;

final class SomeClass
{
    public function doSomeThing(): void
    {
        // Call post-processing function for constructor:
        if (is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][self::class]['Some-PostProc'])) {
            $_params = ['pObj' => &$this];
            foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][self::class]['Some-PostProc'] as $_funcRef) {
                GeneralUtility::callUserFunction($_funcRef, $_params, $this);
            }
        }
    }
}
