<?php

namespace App\Infrastructure\Interfaces\Services;

use App\Exceptions\TransactionException;

/**
 * Transaction Manager Interface
 *
 * Provides a contract for managing database transactions
 * with automatic rollback on failure.
 */
interface TransactionManagerInterface
{
    /**
     * Execute a callback within a database transaction.
     *
     * @param callable $callback The callback to execute
     * @return mixed The result of the callback
     * @throws TransactionException When the transaction fails
     */
    public function execute(callable $callback): mixed;
}
