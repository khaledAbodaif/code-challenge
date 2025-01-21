<?php

namespace App\Infrastructure\Services\Order\OrderProcessors;


use App\Infrastructure\Interfaces\Services\Order\OrderProcessor\ProductProcessorInterface;
use App\Infrastructure\Interfaces\Services\ProductServiceInterface;
use Illuminate\Support\Collection;

/**
 * {@inheritdoc}
 */
class ProductProcessor implements ProductProcessorInterface
{

    public function __construct(
        private readonly ProductServiceInterface $productService
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function mapFromOrderData(array $orderData): Collection
    {
        $collection = collect($orderData);

        $productIds = $this->getProductIds($collection);
        $products = $this->productService->getAvailableProductsById($productIds);

        return $this->assignProductToQuantity($products,$collection);
    }

    /**
     * Extract product IDs from a collection of order items
     *
     * Transforms a collection of order items into an array of unique product IDs

     * @param Collection $collection Collection of order items
     * @return array Array of product IDs
     */
    private function getProductIds(Collection $collection): array
    {
        return $collection->pluck('productId')->values()->toArray();
    }

    /**
     * Map products to their requested quantities from the order input
     *
     * Combines product details with requested quantities into a structured format.
     * Filters out any products that don't match the order input.
     * @param \Illuminate\Database\Eloquent\Collection $products Collection of product models
     * @param Collection $collection Collection of order inputs with productId and quantity
     * @return Collection Collection of matched products with their quantities
     */
    private function assignProductToQuantity(\Illuminate\Database\Eloquent\Collection $products ,Collection $collection ): Collection
    {
        return $products->map(function ($product) use ($collection) {
            $matchingInput = $collection->firstWhere('productId', $product->id);
            return $matchingInput ? [
                'product' => $product,
                'quantity' => $matchingInput->quantity
            ] : null;
        })->filter();
    }

}
