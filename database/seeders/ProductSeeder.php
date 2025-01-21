<?php

namespace Database\Seeders;

use App\Enums\UnitEnum;
use App\Exceptions\ProductCreationException;
use App\Infrastructure\DTOs\ProductDTO;
use App\Infrastructure\Interfaces\Services\ProductServiceInterface;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{

    // Define known ingredient IDs (because it's already known)

    protected array $products = [
        [
            'name' => 'Classic Burger',
            'description' => 'Our signature beef burger with cheese and fresh onions',
            'price' => 10.99,
            'ingredients' => [
                [
                    'ingredient_id' => 1,
                    'quantity' => 150,
                    'unit' => UnitEnum::GRAM,
                ],
                [
                    'ingredient_id' => 2,
                    'quantity' => 30,
                    'unit' => UnitEnum::GRAM,
                ],
                [
                    'ingredient_id' => 3,
                    'quantity' => 20,
                    'unit' => UnitEnum::GRAM,
                ],

            ]
        ],
        [
            'name' => 'Double Cheeseburger',
            'description' => 'Double beef patty with extra cheese',
            'price' => 15.99,
            'ingredients' => [
                [
                    'ingredient_id' => 1,
                    'quantity' => 300,
                    'unit' => UnitEnum::GRAM,
                ],
                [
                    'ingredient_id' => 2,
                    'quantity' => 60,
                    'unit' => UnitEnum::GRAM,
                ],
                [
                    'ingredient_id' => 3,
                    'quantity' => 40,
                    'unit' => UnitEnum::GRAM,
                ],
            ]
        ],
        [
            'name' => 'Kids Burger',
            'description' => 'Small sized burger perfect for kids',
            'price' => 6.99,
            'ingredients' => [
                [
                    'ingredient_id' => 1,
                    'quantity' => 75.5,
                    'unit' => UnitEnum::GRAM,
                ],
                [
                    'ingredient_id' => 2,
                    'quantity' => 15,
                    'unit' => UnitEnum::GRAM,
                ],
                [
                    'ingredient_id' => 3,
                    'quantity' => 10.5,
                    'unit' => UnitEnum::GRAM,
                ],
            ]
        ],
    ];

    public function __construct(private readonly ProductServiceInterface $productService)
    {
    }

    /**
     * Run the database seeds.
     * @throws ProductCreationException
     */
    public function run(): void
    {

        try {

        if ($this->productService->isTableEmpty()) {
            foreach ($this->products as $item) {

                $this->productService->createWithIngredients(ProductDTO::fromArray($item));

            }

        }}catch (\Exception $exception){

        }
    }


}
