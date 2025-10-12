<?php

declare(strict_types=1);

namespace T3docs\BmiCalculator\Domain\Model\Dto;

use TYPO3\CMS\Extbase\Attribute\Validate;

final class MeasurementsDto
{
    // Ensure that the height is in meters, not centimeters
    #[Validate(['validator' => 'NotEmpty'])]
    #[Validate([
        'validator' => 'NumberRange',
        'options' => ['minimum' => 0.5, 'maximum' => 2.5],
    ])]
    private float $height;
    // Weight must not be empty
    #[Validate(['validator' => 'NotEmpty'])]
    private int $weight;

    public function __construct(?float $height, ?int $weight)
    {
        $this->height = $height ?? 0;
        $this->weight = $weight ?? 0;
    }

    // getters and setters
}
