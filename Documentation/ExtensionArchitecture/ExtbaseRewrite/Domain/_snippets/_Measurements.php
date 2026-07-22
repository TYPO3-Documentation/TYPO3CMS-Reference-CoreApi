<?php

declare(strict_types=1);

namespace T3docs\BmiCalculator\Domain\Model;

use T3docs\BmiCalculator\Domain\Model\Dto\MeasurementsDto;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

final class Measurements extends AbstractEntity
{
    protected int $height = 0;
    protected int $weight = 0;

    public static function fromMeasurementsDto(MeasurementsDto $measurementsDto): self
    {
        $model = new self();
        $model->weight = $measurementsDto->getWeight();
        $model->height = (int)($measurementsDto->getHeight() * 100);
        return $model;
    }
    // Getters and Setters
}
