<?php

namespace App\Providers;

use App\Http\Interfaces\RepositoryInterface;
use App\Http\Repositories\RepositoryClass;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RepositoryInterface::class, RepositoryClass::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
