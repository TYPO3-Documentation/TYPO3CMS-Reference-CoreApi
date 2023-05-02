<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;

final class SomeClass
{
    public function doSomeThing()
    {
        // Hook for processing data submission to extensions
        foreach ($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['my_custom_hook']
                 ['checkDataSubmission'] ?? [] as $className) {
            $_procObj = GeneralUtility::makeInstance($className);
            $_procObj->checkDataSubmission($this);
        }
    }
}
