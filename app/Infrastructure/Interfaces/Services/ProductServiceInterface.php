<?php

namespace App\Infrastructure\Interfaces\Services;


use App\Exceptions\ProductCreationException;
use App\Exceptions\ProductNotFoundException;
use App\Infrastructure\DTOs\ProductDTO;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

/**
 * Product Service Interface
 *
 * Defines the contract for product-related operations including
 * creation and availability checks.
 */
interface ProductServiceInterface
{
    /**
     * Create a new product.
     * @param ProductDTO $dto The product data transfer object
     * @return Product The created product
     * @throws ProductCreationException When validation fails
     */
    public function createWithIngredients(ProductDTO $dto): Product;

    /**
     * Check if the products table is empty.
     *
     * Useful for initial setup and seeding operations.
     *
     * @return bool True if table is empty, false otherwise
     */
    public function isTableEmpty(): bool;

    /**
     * Check product availability by IDs.
     *
     * @param array<int> $ids Array of product IDs to check
     * @throws ProductNotFoundException When products not found
     */
    public function getAvailableProductsById(array $ids): Collection;
}
