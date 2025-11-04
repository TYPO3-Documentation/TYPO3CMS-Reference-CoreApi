<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Mvc\Controller;

use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;

final readonly class NonExtbaseController
{
    public function __construct(private FlexFormTools $flexFormTools) {}

    public function indexAction(array $ttContentRow): void
    {
        $flexformData = $this->loadFlexForm($ttContentRow['pi_flexform'] ?? '');
        // Do something
    }

    private function loadFlexForm(string $field): array
    {
        if ($field === '') {
            return [];
        }
        return $this->flexFormTools->convertFlexFormContentToArray($field);
    }
}
