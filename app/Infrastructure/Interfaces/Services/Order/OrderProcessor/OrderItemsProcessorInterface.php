<?php

namespace App\Infrastructure\Interfaces\Services\Order\OrderProcessor;

use App\Exceptions\OrderProcessingException;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;

/**
 * Order Items Processor Interface
 *
 * Handles the creation and management of individual order items during
 * the order processing workflow. Responsible for calculating prices,
 * validating quantities, and preparing items for order creation.
 *
 */
interface OrderItemsProcessorInterface
{
/**
     * Prepare order items for an order.
     *
     * This method:
     * 1. Validates item quantities
     * 2. Calculates item prices
     * 3. Prepares items for database insertion
     * 4. Updates order totals
     *
     * @param Collection<int, array{product: Product, quantity: int}> $productsWithQuantity
     *        Collection of products with their requested quantities
     * @param Order $order The order entity to prepare items for
     * @return Order The order with prepared items and updated totals
     * @throws OrderProcessingException When:
     *                                 - Invalid quantity provided
     *                                 - Price calculation fails
     *                                 - Item preparation fails
     */
    public function prepareOrder(Collection $productsWithQuantity, Order $order): Order;
}
