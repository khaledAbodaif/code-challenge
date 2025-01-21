<?php

namespace App\Infrastructure\Interfaces\Services\Order;

use App\Exceptions\InvalidDtoException;
use App\Exceptions\OrderProcessingException;
use App\Infrastructure\DTOs\OrderDto;
use App\Models\Order;

/**
 * Order Service Interface
 *
 * Defines the main contract for order-related operations including creation,
 * retrieval, updating, and cancellation of orders. This service acts as the main
 * entry point for order management in the application.
 *
 */
interface OrderServiceInterface
{
  /**
     * Create a new order.
     *
     * @param array<OrderDto> $data Array of order data DTOs
     * The order data containing:
     *                                   - items: array of order items
     *                                   - customer_id: optional customer ID
     *                                   - notes: optional order notes
     * @return Order The created order with its relationships loaded
     * @throws OrderProcessingException When order creation fails due to:
     *                                 - Invalid product IDs
     *                                 - Insufficient stock
     *                                 - Database transaction failure
     * @throws InvalidDtoException If data not valid dto
   */
    public function create(array $data): Order;
}
