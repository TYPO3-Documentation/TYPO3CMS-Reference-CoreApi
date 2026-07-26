<?php

use TYPO3\CMS\Core\Utility\DebugUtility;

class ModuleController extends ActionController implements LoggerAwareInterface
{
    protected function debugCookies()
    {
        DebugUtility::debug($_COOKIE, 'cookie');
    }
}
