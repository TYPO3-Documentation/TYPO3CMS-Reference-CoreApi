<?php

declare(strict_types=1);

namespace T3docs\BmiCalculator\Domain\Model\Dto;

final class MeasurementsDto
{
    private float $height;
    private int $weight;

    public function __construct(?float $height = 0, ?int $weight = 0)
    {
        $this->height = $height ?? 0;
        $this->weight = $weight ?? 0;
    }

    // getters and setters
}
