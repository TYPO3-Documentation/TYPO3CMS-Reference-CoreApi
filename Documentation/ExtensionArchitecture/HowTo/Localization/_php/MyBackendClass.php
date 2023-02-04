<?php
declare(strict_types=1);

namespace MyVendor\MyExtension\Backend;

use TYPO3\CMS\Core\Localization\LanguageService;

final class MyBackendClass
{
    private function translateSomething(string $input): string
    {
        return $this->getLanguageService()->sL($input);
    }

    private function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    // ...
}