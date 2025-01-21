<?php

namespace App\Infrastructure\Interfaces\Services\Order\OrderProcessor;

use App\Exceptions\ProductNotFoundException;
use App\Models\Product;
use Illuminate\Support\Collection;

/**
 * Product Processor Interface
 *
 * Responsible for handling product-related operations during order processing.
 * This includes validating product existence, availability, and mapping
 * product data to the required format for order processing.
 *
 * @package App\Interfaces\Services\Order\OrderProcessor
 */
interface ProductProcessorInterface
{
   /**
     * Map and validate products from order data.
     *
     * This method:
     * 1. Extracts product IDs from order data
     * 2. Validates product existence
     * 3. Checks product availability
     * 4. Maps products to the required format
     *
     * @param array<string, mixed> $orderData The order data containing:
     *                                        - items: array of items with product_id and quantity
     * @return Collection<int, Product> Collection of validated and mapped products
     * @throws ProductNotFoundException When:
     *                                 - Product ID doesn't exist
     *                                 - Product is not available
     *                                 - Product is inactive
     */
    public function mapFromOrderData(array $orderData): Collection;
}
