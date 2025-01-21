<?php

namespace App\Infrastructure\DTOs;

use App\Infrastructure\ValueObjects\Money;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ProductDTO
{

    private const MAX_NAME_LENGTH = 255;

    public function __construct(
        public readonly string $name,
        public readonly Money  $price,

        /** @var ProductIngredientDto[] */
        public readonly array  $ingredients,
        public readonly ?int     $id = null,
        public readonly ?Carbon  $created_at = null,
        public readonly ?Carbon  $updated_at = null,
    )
    {
        $this->validate();
    }

    public static function fromArray(array $data): self
    {
        //validation layer if not set
        return new self(
            name: $data['name'],
            price: new Money($data['price']),
            ingredients: ProductIngredientDTO::fromMultipleArray($data['ingredients']),
        );
    }

    private function validate()
    {
        match (true) {

            strlen($this->name) > self::MAX_NAME_LENGTH => throw new \InvalidArgumentException('name length is too large. '),
            !$this->validateIngredients() => throw new \InvalidArgumentException('ingredients invalid. '),

            default => true
        };

    }

    private function validateIngredients(): bool
    {

        if (empty($this->ingredients)) {
            return false;
        }

        foreach ($this->ingredients as $ingredient) {
            if (!$ingredient instanceof ProductIngredientDTO) {
                return false;
            }
        }

        return true;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price->getValue(),
        ];
    }

    public function getIngredients(): array
    {
        return array_map(fn($ingredient) => $ingredient->toArray(), $this->ingredients);

    }

    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }

}
