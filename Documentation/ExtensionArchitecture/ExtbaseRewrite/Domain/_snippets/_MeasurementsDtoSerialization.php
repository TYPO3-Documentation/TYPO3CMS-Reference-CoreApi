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

    public function serialize(): string
    {
        return json_encode(
            [
                'height' => $this->height,
                'weight' => $this->weight,
            ],
        );
    }

    public static function deserialize(string $sessionData): self
    {
        $data = json_decode($sessionData);
        if (!is_object($data) || !isset($data->height) || !isset($data->weight)) {
            print_r($data);
            throw new \RuntimeException('Deserialization failed ');
        }
        return new self(
            height: (float)$data->height,
            weight: (int)$data->weight,
        );
    }

    // Getters and setters
}
