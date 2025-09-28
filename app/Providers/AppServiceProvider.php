<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Sale\SaleInterface;
use App\Repositories\Sale\SaleEloquent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SaleInterface::class, SaleEloquent::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
