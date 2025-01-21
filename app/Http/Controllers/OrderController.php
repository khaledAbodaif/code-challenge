<?php

namespace App\Http\Controllers;


use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Infrastructure\DTOs\OrderDto;
use App\Infrastructure\Helpers\ApiResponse;
use App\Infrastructure\Interfaces\Services\Order\OrderServiceInterface;
use Illuminate\Http\JsonResponse;

/**
 * Handles order-related HTTP requests.
 *
 * This controller is responsible for managing order operations like creation,
 * retrieval, updates, and deletions through the API endpoints.
 */
class OrderController
{

    /**
     * Initialize a new OrderController instance.
     *
     * @param OrderServiceInterface $orderService The service handling order business logic
     */

    public function __construct(private readonly OrderServiceInterface $orderService)
    {
    }

    /**
     * Create a new order.
     *
     * Processes the incoming request to create a new order in the system.
     * Validates the request data and transforms it into the required format
     * before passing it to the order service for creation.
     *
     * @param OrderStoreRequest $request The validated request containing order data
     * @return JsonResponse Returns a JSON response with:
     *                      - Created order data on success
     *                      - Error response if order creation fails
     *
     * @throws \Exception When order creation fails due to service layer errors
     */
    public function store(OrderStoreRequest $request): JsonResponse
    {

        try {

            $orderData = OrderDto::fromMultipleArray($request->validated()['products']);
            $order = $this->orderService->create($orderData);
            if (!$order->exists) {
                return ApiResponse::error();
            }

        } catch (\Exception $exception) {
            return ApiResponse::error($exception->getMessage());

        }


        return ApiResponse::dataCreated(OrderResource::make($order));

    }
}
