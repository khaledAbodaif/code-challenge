<?php

namespace App\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


/*
 * this abstract table for common repository methods
 * doesn't contain and abstracted methods only for reduce redundancy
 * */
abstract class BaseRepository
{

    use DBTransactionTrait;
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



}
