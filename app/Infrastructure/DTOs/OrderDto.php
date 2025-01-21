<?php

namespace App\Infrastructure\DTOs;

use App\Exceptions\InvalidDtoException;
use App\Infrastructure\ValueObjects\Quantity;


/**
 * Class OrderData
 *
 * Data Transfer Object for order data validation and transformation.
 *
 */
class OrderDto
{
    /**
     * @param int $productId The ID of the product being ordered
     * @param Quantity $quantity The quantity of the product
     */
    public function __construct(
        public readonly int $productId,
        public readonly Quantity $quantity,
    ) {}

    /**
     * Creates an OrderData instance from an array.
     *
     * @param array $data
     * @return self
     * @throws InvalidDtoException
     */
    public static function fromArray(array $data): self
    {
        self::validateArrayCreation($data);

        return new self(
            productId: $data['product_id'],
            quantity: new Quantity($data['quantity'])
        );
    }

    /**
     * Creates multiple OrderData instances from an array of arrays.
     *
     * @param array $data
     * @return array<OrderDto>
     */
    public static function fromMultipleArray(array $data): array
    {
        return array_map(fn(array $items) => self::fromArray($items), $data);
    }


    /**
     * Validates the input array structure.
     *
     * @param array $data
     * @throws InvalidDtoException
     */
    private static function validateArrayCreation(array $data): void
    {
        if (!isset($data['product_id'], $data['quantity'])) {
            throw new \InvalidArgumentException('Missing required fields: product_id, quantity');
        }
    }
}
