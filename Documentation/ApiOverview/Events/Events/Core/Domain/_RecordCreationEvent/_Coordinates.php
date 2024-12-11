<?php

declare(strict_types=1);

namespace MyVendor\MyExtension\Domain\Model;

class Coordinates
{
    public float $latitude = 0.0;
    public float $longitude = 0.0;

    /**
     * @param mixed $value - Accepts a string (e.g., "12.34,56.78")
     */
    public function __construct(mixed $value)
    {
        if (is_string($value)) {
            $parts = explode(',', $value);
            if (count($parts) === 2) {
                $this->latitude = (float)trim($parts[0]);
                $this->longitude = (float)trim($parts[1]);
            }
        }
    }
}
