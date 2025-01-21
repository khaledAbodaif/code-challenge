<?php

namespace Database\Seeders;

use App\Enums\UnitEnum;
use App\Infrastructure\DTOs\IngredientDto;
use App\Infrastructure\Interfaces\Ingredient\IngredientServiceInterface;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    protected array $ingredients = [
        [
            'id'=>1,
            'name' => 'Beef',
            'stock_quantity' => 20,
            'initial_stock_quantity' => 20,
            'unit' => UnitEnum::KILOGRAM,

        ],
        [
            'id'=>2,
            'name' => 'Cheese',
            'stock_quantity' => 5,
            'initial_stock_quantity' => 5,
            'unit' => UnitEnum::KILOGRAM,

        ],
        [
            'id'=>3,
            'name' => 'Onion',
            'stock_quantity' => 1,
            'initial_stock_quantity' => 1,
            'unit' => UnitEnum::KILOGRAM,
        ],
    ];

    public function __construct(private readonly IngredientServiceInterface $ingredientService)
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        if ($this->ingredientService->isTableEmpty()) {

            $dtos = IngredientDto::fromMultipleArray($this->ingredients);
            $this->ingredientService->createMany($dtos);
        }

    }

}
