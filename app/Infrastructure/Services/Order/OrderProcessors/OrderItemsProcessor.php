<?php

namespace App\Infrastructure\Services\Order\OrderProcessors;

use App\Infrastructure\Interfaces\Services\Order\OrderProcessor\OrderItemsProcessorInterface;
use App\Infrastructure\ValueObjects\Money;
use App\Infrastructure\ValueObjects\Quantity;
use App\Models\Order;

use Illuminate\Support\Collection;

/**
 * {@inheritdoc}
 */
class OrderItemsProcessor implements OrderItemsProcessorInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepareOrder(Collection $productsWithQuantity, Order $order): Order
    {
        $order->total_quantity = 0;
        $order->total_price = 0;

        $productsWithQuantity->each(function ($product) use ($order) {
            $this->processOrderItem($order, $product);
        });

        return $order;
    }


    /**
     * Process a single order item by updating order totals and adding item details
     *
     * This method handles the processing of a single product within an order:
     * 1. Creates Money and Quantity value objects from raw data
     * 2. Updates the order's running totals
     * 3. Adds the item details to the order's items collection
     *
     * @param Order $order The order being processed
     * @param array $product
     * @return void
     */
    private function processOrderItem(Order $order, array $product): void
    {
        $quantity = $product['quantity'];
        $price = new Money($product['product']['price']);

        $this->updateOrderTotals($order, $quantity, $price);
        $this->addOrderItem($order, $product, $price, $quantity);
    }

    /**
     * Update order totals by adding item quantity and price
     *
     * Calculates and updates:
     * - Total quantity of items in the order
     * - Total price of the order by adding (price * quantity)
     *
     * @param Order $order The order to update
     * @param Quantity $quantity Quantity of items being added
     * @param Money $price Unit price of the item
     * @return void
     */
    private function updateOrderTotals(Order $order, Quantity $quantity, Money $price): void
    {
        $order->total_quantity += $quantity->getValue();
        $order->total_price += $price->multiply($quantity->getValue())->getValue();
    }


    /**
     * Add an item to the order's items collection
     *
     * Creates a structured array representing the order item with:
     * - Product ID
     * - Quantity
     * - Unit price
     * - Total price (unit price * quantity)
     *
     * @param Order $order The order to add the item to
     * @param array $product Product data array containing product details
     * @param Money $price Unit price of the product
     * @param Quantity $quantity Quantity being ordered
     * @return void
     */
    private function addOrderItem(Order $order, array $product, Money $price, Quantity $quantity): void
    {
        $order->items[] = [
            'product_id' => $product['product']['id'],
            'quantity' => $quantity->getValue(),
            'unit_price' => $price->getValue(),
            'total_price' => $price->multiply($quantity->getValue())->getValue(),
        ];
    }
}
