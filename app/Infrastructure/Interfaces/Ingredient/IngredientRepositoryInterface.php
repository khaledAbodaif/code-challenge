<?php

namespace App\Infrastructure\Interfaces\Ingredient;

use App\Infrastructure\Interfaces\Repositories\RepositoryInterface;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

/**
 * Ingredient Repository Interface
 *
 * Defines the contract for ingredient data persistence operations.
 * Extends the base repository interface with ingredient-specific
 * operations for managing ingredient data in the database.
 *
 * @extends RepositoryInterface
 */
interface IngredientRepositoryInterface extends RepositoryInterface
{

 /**
     * Insert multiple ingredients into the database.
     *
     * Performs a bulk insert operation for multiple ingredient records.
     * This method is optimized for inserting large datasets.
     *
     * @param array<int, array<string, mixed>> $data Array of ingredient data
     * @return void
     * @throws QueryException When insert operation fails
     */
    public function insert(array $data): void;

    /**
     * Update an ingredient's attributes.
     *
     * Updates specific attributes of an ingredient identified by its ID.
     * Only provided attributes will be updated.
     *
     * @param int $id The ingredient ID to update
     * @param array<string, mixed> $data The data to update,
     * @return bool True if update successful, false if ingredient not found
     * @throws QueryException When update operation fails
     */
    public function update(int $id, array $data): bool;

     /**
     * Lock and retrieve active ingredients by IDs.
     *
     * Acquires a database lock on specified active ingredients to prevent
     * concurrent modifications. Typically used during stock updates to
     * prevent race conditions.
     *
     * @param array<int> $ids Array of ingredient IDs to lock
     * @return Collection<int, Ingredient> Collection of locked active ingredients
     * @throws QueryException When lock operation fails
     */
    public function lockTableWhereActiveIds(array $ids): Collection;

}
