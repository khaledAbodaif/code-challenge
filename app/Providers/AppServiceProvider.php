<?php

namespace App\Providers;

use App\Infrastructure\Interfaces\Repositories\OrderRepositoryInterface;
use App\Infrastructure\Interfaces\Repositories\ProductRepositoryInterface;
use App\Infrastructure\Interfaces\Services\IngredientServiceInterface;
use App\Infrastructure\Interfaces\Repositories\IngredientRepositoryInterface;
use App\Infrastructure\Interfaces\Services\Order\OrderProcessor\IngredientProcessorInterface;
use App\Infrastructure\Interfaces\Services\Order\OrderProcessor\OrderItemsProcessorInterface;
use App\Infrastructure\Interfaces\Services\Order\OrderProcessor\OrderProcessorInterface;
use App\Infrastructure\Interfaces\Services\Order\OrderProcessor\ProductProcessorInterface;
use App\Infrastructure\Interfaces\Services\Order\OrderServiceInterface;
use App\Infrastructure\Interfaces\Services\ProductServiceInterface;
use App\Infrastructure\Interfaces\Services\TransactionManagerInterface;
use App\Infrastructure\Repositories\IngredientRepository;
use App\Infrastructure\Repositories\OrderRepository;
use App\Infrastructure\Repositories\ProductRepository;
use App\Infrastructure\Services\Ingredient\IngredientService;

use App\Infrastructure\Services\Order\OrderProcessors\IngredientProcessor;
use App\Infrastructure\Services\Order\OrderProcessors\OrderItemsProcessor;
use App\Infrastructure\Services\Order\OrderProcessors\OrderProcessor;
use App\Infrastructure\Services\Order\OrderProcessors\ProductProcessor;
use App\Infrastructure\Services\Order\OrderService;
use App\Infrastructure\Services\Product\ProductService;
use App\Infrastructure\Services\TransactionManager;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRepositories();
        $this->registerServices();
        $this->registerProcessors();

        $this->app->bind(TransactionManagerInterface::class, TransactionManager::class);

    }

    private function registerRepositories(): void
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(IngredientRepositoryInterface::class, IngredientRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

    }

    private function registerServices(): void
    {
        $this->app->bind(IngredientServiceInterface::class, IngredientService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);

    }

    private function registerProcessors(): void
    {
        $this->app->bind(OrderProcessorInterface::class, OrderProcessor::class);
        $this->app->bind(ProductProcessorInterface::class, ProductProcessor::class);
        $this->app->bind(IngredientProcessorInterface::class, IngredientProcessor::class);
        $this->app->bind(OrderItemsProcessorInterface::class, OrderItemsProcessor::class);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
