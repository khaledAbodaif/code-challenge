<?php

namespace App\Infrastructure\Services\Order\OrderProcessors;

use App\Exceptions\InsufficientStockException;
use App\Exceptions\OrderProcessingException;

use App\Exceptions\ProductNotFoundException;
use App\Infrastructure\Interfaces\Services\Order\OrderProcessor\IngredientProcessorInterface;
use App\Infrastructure\Interfaces\Services\Order\OrderProcessor\OrderItemsProcessorInterface;
use App\Infrastructure\Interfaces\Services\Order\OrderProcessor\OrderProcessorInterface;
use App\Infrastructure\Interfaces\Services\Order\OrderProcessor\ProductProcessorInterface;
use App\Models\Order;
use Illuminate\Support\Collection;

/**
 * {@inheritdoc}
 */
class OrderProcessor implements OrderProcessorInterface
{
    public function __construct(
        private readonly IngredientProcessorInterface $ingredientProcessor,
        private readonly ProductProcessorInterface $productProcessor,
        private readonly OrderItemsProcessorInterface $orderItemService
    ) {
    }

    /**
     * {@inheritdoc}
     * @throws InsufficientStockException
     * @throws ProductNotFoundException
     */
    public function process(array $orderData): Order
    {
        $mappedProducts = $this->productProcessor->mapFromOrderData($orderData);
        $this->ingredientProcessor->processForOrder($mappedProducts);

        return $this->prepareOrder($mappedProducts);

    }

    /**
     * Prepares the final order with items and totals.
     *
     * @param Collection $mappedProducts Collection of mapped products with quantities
     * @return Order The prepared order
     * @throws OrderProcessingException
     */
    private function prepareOrder(Collection $mappedProducts): Order
    {
        return $this->orderItemService->prepareOrder(
            $mappedProducts,
            new Order()
        );
    }


}
