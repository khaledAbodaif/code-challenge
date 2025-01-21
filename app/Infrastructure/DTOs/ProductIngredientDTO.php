<?php

namespace App\Infrastructure\DTOs;

use App\Enums\UnitEnum;
use App\Infrastructure\ValueObjects\Quantity;
use App\Models\Ingredient;
use App\Models\Product;
use Carbon\Carbon;

class ProductIngredientDTO
{
    // i think this should contain the ingradiant dto it self and the pivot
    public function __construct(
        public readonly ?int $ingredientId,
        public readonly Quantity $quantity,
        public readonly UnitEnum $unit = UnitEnum::GRAM,
        public readonly ?Carbon  $created_at = null,
        public readonly ?Carbon  $updated_at = null,
        public readonly ?IngredientDto $ingredient = null,

    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            ingredientId: $data['ingredient_id'],
            quantity: new Quantity($data['quantity']),
            unit: $data['unit']
        );
    }

    public function toArray(): array
    {
        return [
            'ingredient_id' => $this->ingredientId,
            'quantity' => $this->quantity->getValue(),
            'unit' =>$this->unit ,
        ];
    }

    public static function fromMultipleArray(array $data): array
    {
        return array_map(fn(array $ingredient) => self::fromArray($ingredient), $data);
    }

    public static function fromModel(Product $product): self
    {
        return new self(
            ingredientId: $product->ingredients?->pivot->ingredient_id,
            quantity: $product->ingredients?->pivot->quantity,
            unit: $product->ingredients?->pivot->unit,
            created_at: $product->ingredients?->pivot->created_at,
            updated_at: $product->ingredients?->pivot->updtad_at,
            ingredient: IngredientDto::fromModel($product->ingredients),
        );
    }
}
