<?php

namespace App\Infrastructure\Services\Product;


use App\Events\ProductCreatedEvent;
use App\Exceptions\ProductCreationException;
use App\Exceptions\ProductNotFoundException;
use App\Infrastructure\DTOs\ProductDTO;
use App\Infrastructure\Interfaces\Repositories\ProductRepositoryInterface;
use App\Infrastructure\Interfaces\Services\ProductServiceInterface;
use App\Infrastructure\Interfaces\Services\TransactionManagerInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

/**
 * {@inheritdoc}
 */
class ProductService  implements ProductServiceInterface
{

    public function __construct(
        private readonly ProductRepositoryInterface  $productRepository,
        private readonly TransactionManagerInterface $transactionManager
    )
    {
    }

    /**
     * {@inheritdoc}
     */
    public function createWithIngredients(ProductDTO $dto): Product
    {
        try {
            return $this->transactionManager->execute(function () use ($dto) {

                // create product
                $savedProduct = $this->productRepository->create($dto->toArray());
                // attach ingredients to product
                $this->productRepository->attachIngredients($dto->getIngredients(), $savedProduct);

                // return fresh model
                $savedProduct = $savedProduct->fresh(['ingredients']);

                event(new ProductCreatedEvent($savedProduct));

                return $savedProduct;
            });
        } catch (\Throwable $e) {
            throw new ProductCreationException(
                "Failed to process product: {$e->getMessage()}",
                previous: $e
            );
        }

    }

    /**
     * {@inheritdoc}
     */
    public function isTableEmpty(): bool
    {
        return $this->productRepository->isTableEmpty();
    }


    /**
     * {@inheritdoc}
     */
    public function getAvailableProductsById(array $ids): Collection
    {
        $products = $this->productRepository->getAvailableByIds($ids);

        if (count($ids) > $products->count()) {
            throw new ProductNotFoundException(
                message: "missing products",
                context: [
                    "required" => $ids,
                    "found" => $products?->pluck('id')->flatten()->toArray()
                ]
            );
        }

        return $products;
    }


}
