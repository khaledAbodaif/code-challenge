<?php

namespace App\Infrastructure\Interfaces\Repositories;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;


/**
 * Interface ProductRepositoryInterface
 *
 * Handles product-specific database operations and queries.
 * Extends the base repository interface with product-specific functionality.
 *
 * @extends RepositoryInterface
 */
interface ProductRepositoryInterface extends RepositoryInterface
{

    /**
     * Retrieve available products by their IDs.
     *
     * @param array $ids An array of product IDs to retrieve
     *
     * @throws ModelNotFoundException When products are not found
     * @throws QueryException When the query fails
     *
     * @return Collection Collection of available products
     */
    public function getAvailableByIds(array $ids): Collection;

    /**
     * Attach ingredients to a product.
     *
     * @param array $ingredients Array of ingredient data to attach

     * @param Model|Product $product The product model instance
     *
     * @throws QueryException When the attachment fails
     *
     * @return void
     */
    public function attachIngredients(array $ingredients, Model|Product $product): void;



}
