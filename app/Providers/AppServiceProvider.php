<?php

namespace App\Providers;

use App\Infrastructure\Interfaces\Repositories\ProductRepositoryInterface;
use App\Infrastructure\Interfaces\Services\IngredientServiceInterface;
use App\Infrastructure\Interfaces\Repositories\IngredientRepositoryInterface;
use App\Infrastructure\Interfaces\Services\ProductServiceInterface;
use App\Infrastructure\Interfaces\Services\TransactionManagerInterface;
use App\Infrastructure\Repositories\IngredientRepository;
use App\Infrastructure\Repositories\ProductRepository;
use App\Infrastructure\Services\Ingredient\IngredientService;

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

        $this->app->bind(TransactionManagerInterface::class, TransactionManager::class);

    }

    private function registerRepositories(): void
    {
        $this->app->bind(IngredientRepositoryInterface::class, IngredientRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);

    }

    private function registerServices(): void
    {
        $this->app->bind(IngredientServiceInterface::class, IngredientService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);

    }




    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
