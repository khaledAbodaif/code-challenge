<?php

namespace App\Infrastructure\DTOs;

use App\Enums\UnitEnum;
use App\Models\Ingredient;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class IngredientDto
{
    private const MAX_NAME_LENGTH = 255;

    private static array $requiredKeys = ['name', 'stock_quantity', 'unit','initial_stock_quantity'];

    public function __construct(
        public readonly string   $name,
        public readonly float    $stock_quantity,
        public readonly float    $initial_stock_quantity,
        public readonly UnitEnum $unit,
        public readonly ?int     $id = null,
        public readonly ?Carbon  $created_at = null,
        public readonly ?Carbon  $updated_at = null,
        public readonly bool  $stock_alert_sent = false,
    )
    {
        $this->validate();
    }


    public static function fromModel(Ingredient $ingredient): self
    {
        return new self(
            name: $ingredient->name,
            stock_quantity: $ingredient->stock_quantity,
            initial_stock_quantity: $ingredient->initial_stock_quantity,
            unit: $ingredient->unit,
            id: $ingredient->id,
            created_at: $ingredient->created_at,
            updated_at: $ingredient->updtad_at,
            stock_alert_sent: $ingredient->stock_alert_sent,
        );
    }


    public static function fromArray(array $data): self
    {

        self::validateArrayCreation($data);
        return new self(...array_intersect_key($data, array_flip(self::$requiredKeys)));
    }

    public static function fromMultipleArray(array $data): array
    {
        return array_map(fn(array $ingredient) => self::fromArray($ingredient), $data);
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public static function toMultipleArray(array $data): array
    {
        $items =[];
        foreach ($data as $item){
            $items[]=$item->toArray();
        }
        return $items;
    }

    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }

    private function validate(): void
    {

        match (true) {

            $this->stock_quantity <= 0 => throw new \InvalidArgumentException('stock quantity cannot be negative || zero. '),
            empty($this->name) => throw new \InvalidArgumentException('name can not be empty. '),
            strlen($this->name) > self::MAX_NAME_LENGTH => throw new \InvalidArgumentException('name length is too large. '),
            default => true
        };

    }

    private static function validateArrayCreation(array $data): void
    {

        match (true) {
            !isset($data['name'], $data['stock_quantity'], $data['unit']) => throw new \InvalidArgumentException('missing required fields. '),
            (!$data['unit'] instanceof UnitEnum) => throw new \InvalidArgumentException('unit must be an enum. '),
            default => true

        };
    }


}
