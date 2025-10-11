<?php

declare(strict_types=1);

/*
 * This file is part of the package t3docs/bmi-calculator.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace T3docs\BmiCalculator\Domain\Model\Dto;

use TYPO3\CMS\Extbase\Annotation\Validate;

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
