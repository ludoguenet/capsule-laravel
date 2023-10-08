<?php

declare(strict_types=1);

namespace App\DataObjects;

use InvalidArgumentException;

class MoneyDTO
{
    private int $price;

    public function __construct(
        mixed $value,
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException('Price can not be negative');
        }

        match (true) {
            is_int($value) => $this->price = $value,
            is_float($value) => $this->price = $this->convertFromFloat($value),
            is_string($value) => $this->price = $this->convertFromString($value),
            default => throw new InvalidArgumentException('Bad type'),
        };
    }

    public function priceInCents(): int
    {
        return $this->price;
    }

    private function convertFromFloat(float $value): int
    {
        return intval(round($value, 2) * 100);
    }

    private function convertFromString(string $value): int
    {
        return $this->convertFromFloat(floatval($value));
    }
}
