<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Configuration\Processor\Placeholder;

use TYPO3\CMS\Core\Configuration\Processor\Placeholder\PlaceholderProcessorInterface;

final class ExamplePlaceholderProcessor implements PlaceholderProcessorInterface
{
    public function canProcess(string $placeholder, array $referenceArray): bool
    {
        return str_contains($placeholder, '%example(');
    }

    public function process(string $value, array $referenceArray)
    {
        // do some processing
        $result = $this->getValue($value);

        // Throw this exception if the placeholder can't be substituted
        if ($result === null) {
            throw new \UnexpectedValueException('Value not found', 1581596096);
        }
        return $result;
    }

    private function getValue(string $value): ?string
    {
        // implement logic to fetch specific values from an external service
        // or just add simple mapping logic - whatever is appropriate
        $aliases = [
            'foo' => 'F-O-O',
            'bar' => 'ARRRRR',
        ];
        return $aliases[$value] ?? null;
    }
}
