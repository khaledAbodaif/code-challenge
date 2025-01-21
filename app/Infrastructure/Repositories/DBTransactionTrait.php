<?php

namespace App\Infrastructure\Repositories;

use Illuminate\Support\Facades\DB;

trait DBTransactionTrait
{

    /**
     * Begin a database transaction.
     *
     * @return void
     */
    public function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    /**
     * Commit a database transaction.
     *
     * @return void
     */
    public function commitTransaction(): void
    {
        DB::commit();
    }

    /**
     * Rollback a database transaction.
     *
     * @return void
     */
    public function rollbackTransaction(): void
    {
        DB::rollBack();
    }
}
