<?php

namespace App\Providers;

use App\Infrastructure\Interfaces\Services\IngredientServiceInterface;
use App\Infrastructure\Interfaces\Repositories\IngredientRepositoryInterface;
use App\Infrastructure\Repositories\IngredientRepository;
use App\Infrastructure\Services\Ingredient\IngredientService;
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


    }

    private function registerRepositories(): void
    {
        $this->app->bind(IngredientRepositoryInterface::class, IngredientRepository::class);
    }

    private function registerServices(): void
    {
        $this->app->bind(IngredientServiceInterface::class, IngredientService::class);
    }




    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
