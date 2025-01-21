<?php

namespace App\Infrastructure\Interfaces\Services\Order\OrderProcessor;

use App\Exceptions\InsufficientStockException;
use App\Models\Product;
use Illuminate\Support\Collection;

/**
 * Ingredient Processor Interface
 *
 * Manages ingredient-related operations during order processing, including
 * stock validation, reservation, and reduction. Ensures that all required
 * ingredients are available in sufficient quantities before order creation.
 *
 */
interface IngredientProcessorInterface
{
/**
     * Process ingredients for an order.
     *
     * This method:
     * 1. Extracts required ingredients from products
     * 2. Validates ingredient stock availability
     * 3. Locks the ingredients table for update to prevent race conditions
     * 4. Reduces the quantity of each ingredient based on product quantities
     *
     * @param Collection<int, Product> $products Collection of products in the order
     * @return void
     * @throws InsufficientStockException When:
     *                                    - Required ingredient not found
     *                                    - Insufficient stock quantity
     *                                    - Stock reservation fails
     */
    public function processForOrder(Collection $products): void;
}
