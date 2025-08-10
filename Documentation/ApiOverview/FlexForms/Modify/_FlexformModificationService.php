<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Service;

use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class _FlexformModificationService
{
    public function __construct(
        protected readonly FlexFormTools $flexFormTools,
    ) {}

    public function modifyFlexForm(string $flexFormString): string
    {
        $flexFormArray = GeneralUtility::xml2array($flexFormString);
        $changedFlexFormArray = $this->doSomething($flexFormArray);

        // Attention: flexArray2Xml is internal and subject to
        // be changed without notice. Use at your own risk!
        return $this->flexFormTools->flexArray2Xml($changedFlexFormArray, addPrologue: true);
    }

    private function doSomething(array $flexFormArray): array
    {
        // do something to the array
        return $flexFormArray;
    }
}
