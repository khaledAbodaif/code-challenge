<?php

namespace App\Infrastructure\Services\Order\OrderProcessors;

use App\Exceptions\InsufficientStockException;

use App\Infrastructure\Interfaces\Services\IngredientServiceInterface;
use App\Infrastructure\Interfaces\Services\Order\OrderProcessor\IngredientProcessorInterface;
use Illuminate\Support\Collection;

/**
 * {@inheritdoc}
 */
class IngredientProcessor implements IngredientProcessorInterface
{

    public function __construct(
        private readonly IngredientServiceInterface $ingredientService
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function processForOrder(Collection $products): void
    {
        $ingredientIds = $this->extractIngredientIds($products);
        $this->ingredientService->lockTableForUpdate($ingredientIds);
        $this->reduceIngredients($products);
    }


    /**
     * Extract unique ingredient IDs from a collection of products
     *
     * This method flattens the nested ingredients structure and returns
     * a unique array of ingredient IDs
     *
     * @param Collection $products Collection of products with their ingredients
     * @return array Array of unique ingredient IDs
     */
    private function extractIngredientIds(Collection $products): array
    {
        return $products->pluck('product.ingredients')
            ->flatten()
            ->pluck('id')
            ->unique()
            ->values()
            ->toArray();
    }

    /**
     * Reduce the quantity of ingredients based on product orders
     *
     * Iterates through each product and reduces its ingredients
     * according to the ordered quantity
     *
     * @param Collection $products Collection of products with quantities
     * @throws InsufficientStockException When ingredient quantities are insufficient
     * @return void
     */
    private function reduceIngredients(Collection $products): void
    {
        foreach ($products as $product) {
            $this->ingredientService->reduceIngredients(
                $product['product']->ingredients,
                $product['quantity']
            );
        }

    }


}
