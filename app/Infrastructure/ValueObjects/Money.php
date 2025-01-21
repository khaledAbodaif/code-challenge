<?php

namespace App\Infrastructure\ValueObjects;

class Money
{
    public function __construct(
        private readonly float $amount
    ) {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Money amount cannot be negative');
        }
    }

    public function getValue(): float
    {
        return $this->amount;
    }

    public function multiply(int $multiplier): self
    {
        return new self($this->amount * $multiplier);
    }
}
