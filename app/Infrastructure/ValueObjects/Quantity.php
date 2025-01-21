<?php

namespace App\Infrastructure\ValueObjects;

class Quantity
{
    public function __construct(
        private readonly int $value
    ) {
        if ($value <= 0) {
            throw new \InvalidArgumentException('Quantity must be greater than zero');
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
