<?php

namespace App\Infrastructure\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Base Repository Interface
 *
 * Provides basic database operations and transaction management functionality
 * that should be implemented by all repository classes.
 */
interface RepositoryInterface
{
    /**
     * general create method
     * @param array $data
     * @return Model dynamic-model
     */
    public function create(array $dto): Model;

    /**
     * general checking for empty table
     * @return bool
     */
    public function isTableEmpty(): bool;


    /**
     * Start a new database transaction.
     *
     * @return void
     */
    public function beginTransaction(): void;

    /**
     * Commit the active database transaction.
     *
     * @return void
     * @throws \RuntimeException If no active transaction exists
     */
    public function commitTransaction(): void;

    /**
     * Rollback the active database transaction.
     *
     * @return void
     * @throws \RuntimeException If no active transaction exists
     */
    public function rollbackTransaction(): void;


}
