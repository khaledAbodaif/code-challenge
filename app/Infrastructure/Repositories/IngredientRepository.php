<?php

namespace App\Infrastructure\Repositories;

use App\Infrastructure\Interfaces\Repositories\IngredientRepositoryInterface;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Collection;


/**
 * {@inheritdoc}
 */
class IngredientRepository extends BaseRepository implements IngredientRepositoryInterface
{

    public function __construct(Ingredient $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritdoc}
     */
    public function insert(array $data): void
    {
        $this->model::insert($data);

    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data);
    }

    /**
     * {@inheritdoc}
     */
    public function lockTableWhereActiveIds(array $ids): Collection
    {
        return $this->model::lockForUpdate()->where('is_active', 1)->findMany($ids);
    }
}
