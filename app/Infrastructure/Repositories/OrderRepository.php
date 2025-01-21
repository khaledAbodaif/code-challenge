<?php

namespace App\Infrastructure\Repositories;


use App\Infrastructure\Interfaces\Repositories\OrderRepositoryInterface;
use App\Models\Order;

/**
 * {@inheritdoc}
 */
class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{

    public function __construct(Order $model)
    {
        parent::__construct($model);
    }


    /**
     * {@inheritdoc}
     */
    public function createOrderItems(Order $order, array $items): bool
    {
        return (bool) $order->orderItems()->createMany($items);
    }
}
