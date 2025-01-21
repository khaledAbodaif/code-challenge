<?php

namespace App\Infrastructure\Interfaces\Repositories;

use App\Models\Order;
use Illuminate\Database\QueryException;

/**
 * Order Repository Interface
 *
 * Handles persistence operations specific to Order entities.
 * Extends the base repository interface with order-specific operations.
 */
interface OrderRepositoryInterface extends RepositoryInterface
{
    /**
     * Create multiple order items for an existing order.
     *
     * @param Order $order The order to create items for
     * @param array<int, array<string, mixed>> $items Array of order item data
     * @return bool True if items were created successfully
     * @throws QueryException When database operation fails
     */
    public function createOrderItems(Order $order, array $items): bool;
}
