<?php

namespace App\Enums;

enum UnitEnum : string
{

    case GRAM = 'g';
    case KILOGRAM = 'kg';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function toGrams(float $value): float
    {
        return match($this) {
            self::GRAM => $value,
            self::KILOGRAM => $value * 1000,
            default => throw new \InvalidArgumentException('Cannot convert this unit to grams'),
        };
    }

    public function toKilograms(float $value): float
    {
        return match($this) {
            self::GRAM => $value / 1000,
            self::KILOGRAM => $value,
            default => throw new \InvalidArgumentException('Cannot convert this unit to kilograms'),
        };
    }


}
