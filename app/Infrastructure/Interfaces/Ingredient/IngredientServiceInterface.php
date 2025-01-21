<?php

namespace App\Infrastructure\Interfaces\Ingredient;


use App\Exceptions\InsufficientStockException;
use App\Exceptions\InvalidDtoException;
use App\Infrastructure\DTOs\IngredientDto;
use App\Infrastructure\ValueObjects\Quantity;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

/**
 * Ingredient Service Interface
 *
 * Defines the contract for ingredient management operations including creation,
 * updating, and stock management of ingredients. This interface provides methods
 * for handling all ingredient-related business logic in the application.
 *
 */
interface IngredientServiceInterface
{
    /**
     * Create a new ingredient.
     *
     * This method validates and creates a new ingredient record based on
     * the provided DTO data.
     *
     * @param IngredientDto $dto The ingredient data transfer object
     * @return Model|Ingredient The created ingredient model
     * @throws InvalidDtoException When DTO validation fails
     * @throws QueryException When database operation fails
     */
    public function create(IngredientDto $dto): Model|Ingredient;

    /**
     * Check if the ingredients table is empty.
     *
     * Useful for initial setup and seeding operations.
     *
     * @return bool True if table is empty, false otherwise
     */
    public function isTableEmpty(): bool;

    /**
     * Create multiple ingredients at once.
     *
     * Batch creation of ingredients with transaction support to ensure
     * all-or-nothing operation.
     *
     * @param array<IngredientDto> $dtos Array of ingredient DTOs
     * @return void
     * @throws InvalidDtoException When any DTO validation fails
     * @throws QueryException When database operation fails
     */
    public function createMany(array $dtos): void;

    /**
     * Reduce ingredients stock quantities.
     *
     * Updates stock levels for multiple ingredients based on usage quantity.
     * Typically used during order processing.
     *
     * @param Collection<Ingredient> $ingredients Collection of ingredients to update
     * @param Quantity $quantity Amount to reduce from stock
     * @return void
     * @throws InsufficientStockException When stock level would become negative
     * @throws QueryException When database operation fails
     */
    public function reduceIngredients(Collection $ingredients, Quantity $quantity): void;

    /**
     * Update an ingredient's attributes.
     *
     * Updates specific attributes of an ingredient identified by its ID.
     *
     * @param int $id The ingredient ID
     * @param array<string, mixed> $data The data to update,
     * @return bool True if update successful, false otherwise

     */
    public function update(int $id, array $data): bool;

    /**
     * Lock ingredients table for update.
     *
     * Acquires a database lock on specified ingredients to prevent concurrent modifications.
     * Typically used during stock updates to prevent race conditions.
     *
     * @param array<int> $ids Array of ingredient IDs to lock
     * @return Collection<Ingredient> Collection of locked ingredients
     */
    public function lockTableForUpdate(array $ids): Collection;

    /**
     * Check if stock alert should be sent for ingredient.
     *
     * Determines if a stock alert notification should be triggered based on
     * current stock levels and alert settings.
     *
     * @param IngredientDto $dto The ingredient DTO to check
     * @return bool True if alert should be sent, false otherwise
     */
    public function shouldSendStockAlert(IngredientDto $dto): bool;
}
