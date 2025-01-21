<?php

namespace App\Infrastructure\Repositories;

use App\Interfaces\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


/*
 * this abstract table for common repository methods
 * doesn't contain and abstracted methods only for reduce redundancy
 * */
abstract class BaseRepository
{

    public function __construct(protected Model $model)
    {
    }

    /**
     * general create method
     * @param array $data
     * @return Model dynamic-model
     */
    public function create(array $data): Model
    {
        return $this->model::create($data);
    }


    /**
     * general checking for empty table
     * @return bool
     */
    public function isTableEmpty(): bool
    {
        return !$this->model::exists();
    }

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
