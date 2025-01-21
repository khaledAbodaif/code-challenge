<?php

namespace App\Infrastructure\Repositories;

use App\Infrastructure\Interfaces\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }


    /**
     * {@inheritdoc}
     */
    public function getAvailableByIds(array $ids): Collection
    {
       return $this->model::with('ingredients')
            ->select('id','name','price')
            ->whereIn('id',$ids)
            ->get();
    }

    /**
     * {@inheritdoc}
     */
    public function attachIngredients(array $ingredients, Product|Model $product): void
    {
        $product->ingredients()->attach($ingredients);
    }
}
