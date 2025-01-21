<?php

namespace App\Infrastructure\Services;

use App\Exceptions\TransactionException;
use App\Infrastructure\Interfaces\Services\TransactionManagerInterface;
use App\Infrastructure\Repositories\BaseRepository;
use App\Infrastructure\Repositories\DBTransactionTrait;


/**
 * Manages database transactions with automatic commit/rollback handling.
 */
class TransactionManager implements TransactionManagerInterface
{
    use DBTransactionTrait;

    /**
     * Execute a callback within a database transaction.
     *
     * Automatically handles transaction begin, commit, and rollback.
     * If an exception occurs during execution, the transaction is rolled back
     * and a TransactionException is thrown.
     *
     * @param callable $callback The callback to execute within the transaction
     * @return mixed The result of the callback execution
     * @throws TransactionException When the transaction fails
     *
     */
    public function execute(callable $callback): mixed
    {
        try {
            $this->beginTransaction();
            $result = $callback();
            $this->commitTransaction();
            return $result;
        } catch (\Throwable $e) {
            $this->rollbackTransaction();
            throw new TransactionException(
                "Transaction failed: {$e->getMessage()}",
                previous: $e
            );
        }
    }
}

