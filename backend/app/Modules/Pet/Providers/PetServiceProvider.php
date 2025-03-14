<?php

namespace App\Modules\Pet\Providers;

use App\Modules\Pet\Interfaces\PetRepositoryInterface;
use App\Modules\Pet\Interfaces\PetServiceInterface;
use App\Modules\Pet\Repositories\PetRepository;
use App\Modules\Pet\Services\ApiResponseHandler;
use App\Modules\Pet\Services\PetService;
use Illuminate\Support\ServiceProvider;

class PetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PetRepositoryInterface::class, function ($app) {
            return new PetRepository(
                config('services.petstore.base_url'),
                new ApiResponseHandler()
            );
        });

        $this->app->bind(PetServiceInterface::class, function ($app) {
            return new PetService($app->make(PetRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
