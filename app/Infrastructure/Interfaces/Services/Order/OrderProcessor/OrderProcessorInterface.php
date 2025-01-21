<?php

namespace App\Infrastructure\Interfaces\Services\Order\OrderProcessor;

use App\Exceptions\OrderProcessingException;
use App\Models\Order;

/**
 * Order Processor Interface
 *
 * Main processor interface responsible for orchestrating the complete order creation process.
 * This includes validating products, checking stock, processing ingredients, and creating
 * order items. Acts as a facade for the order processing subsystem.
 *
 * @package App\Interfaces\Services\Order\OrderProcessor
 */

interface OrderProcessorInterface
{
    /**
     * Process a complete order through all necessary steps.
     *
     * Processing steps include:
     * 1. Product validation and mapping
     * 2. Ingredient stock verification
     * 3. Order items creation
     * 4. Stock reduction
     * 5. Order finalization
     *
     * @param array<string, mixed> $orderData The order data containing:
     *                                        - items: array of order items with product_id and quantity
     *                                        - customer_data: optional customer information
     *                                        - additional_notes: optional order notes
     * @return Order The fully processed order with relationships loaded
     * @throws OrderProcessingException When any step of the process fails:
     *                                 - Product validation failure
     *                                 - Insufficient stock
     *                                 - Database transaction failure
     */
    public function process(array $orderData): Order;
}
