<?php

namespace App\Infrastructure\Services\Order;

use App\Events\OrderCreatedEvent;
use App\Exceptions\InvalidDtoException;
use App\Exceptions\OrderProcessingException;

use App\Infrastructure\DTOs\OrderDto;
use App\Infrastructure\Helpers\Traits\DtoArrayValidation;
use App\Infrastructure\Interfaces\Repositories\OrderRepositoryInterface;
use App\Infrastructure\Interfaces\Services\Order\OrderProcessor\OrderProcessorInterface;
use App\Infrastructure\Interfaces\Services\Order\OrderServiceInterface;
use App\Infrastructure\Interfaces\Services\TransactionManagerInterface;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Throwable;

/**
 * {@inheritdoc}
 */
class OrderService implements OrderServiceInterface
{
    use DtoArrayValidation;

    /** @var Collection<int, array{product: Product, quantity: int}> Products with their quantities */
    private Collection $productsWithQuantity;

    /** @var array<int> List of ingredient IDs used in the order */
    private array $ingredientIds;



    public function __construct(
        private readonly OrderRepositoryInterface    $orderRepository,
        private readonly TransactionManagerInterface $transactionManager,
        private readonly OrderProcessorInterface $orderProcessor,

    )
    {
    }

    /**
     * {@inheritdoc}
     *
     * Process:
     * 1. Validates input data
     * 2. Processes order through order processor
     * 3. Saves order and its items
     * 4. Dispatches order created event

     */
    public function create(array $data): Order
    {
        $this->validateInput($data);

        try {
            return $this->transactionManager->execute(function () use ($data) {

                $order = $this->orderProcessor->process($data);

                $model = $this->save($order);

                event(new OrderCreatedEvent($model));

                return $model;
            });
        } catch (Throwable $e) {
            throw new OrderProcessingException(
                "Failed to process order: {$e->getMessage()}",
                previous: $e
            );
        }
    }

    /**
     * Saves the order and its related items to the database.
     *
     * This method:
     * 1. Creates the main order record
     * 2. Creates associated order items
     * 3. Reloads the order with its relationships
     *
     * @param Order $order The order entity to save
     * @return Order The saved order with relationships loaded
     */
    private function save(Order $order): Order|Model
    {
        $savedOrder = $this->orderRepository->create($order->toArray());
        $this->orderRepository->createOrderItems($savedOrder, $order->items);
        return $savedOrder->fresh(['orderItems']);

    }



    /**
     * Validates that all elements in the input array are instances of OrderData.
     *
     * Uses the DtoArrayValidation trait to perform validation.
     *
     * @param array $data The input array to validate
     */
    private function validateInput(array $data): void
    {
        $this->dtoInstanceValidation($data, OrderDto::class);
    }


}

