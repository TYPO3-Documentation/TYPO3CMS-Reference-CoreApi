<?php

declare(strict_types=1);
namespace MyVendor\MyExtension\Backend;

use TYPO3\CMS\Backend\Form\Container\AbstractContainer;
use TYPO3\CMS\Core\Page\JavaScriptModuleInstruction;

class SomeContainer extends AbstractContainer
{
    public function render(): array
    {
        $resultArray = $this->initializeResultArray();
        $resultArray['javaScriptModules'][] =
            JavaScriptModuleInstruction::create('@myvendor/my_extension/my-javascript.js');
        // ...
        return $resultArray;
    }
}
