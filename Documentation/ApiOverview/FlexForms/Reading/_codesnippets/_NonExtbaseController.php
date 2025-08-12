<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Mvc\Controller;

use TYPO3\CMS\Core\Service\FlexFormService;

final readonly class NonExtbaseController
{
    public function __construct(
        private FlexFormService $flexFormService,
    ) {}

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
        return $this->flexFormService->convertFlexFormContentToArray($field);
    }
}
