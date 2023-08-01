<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\OrderDetailRepository;
use App\Repositories\Interfaces\OrderDetailRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\ShopRepository;
use App\Repositories\Interfaces\ShopRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\ProductVariantRepository;
use App\Repositories\Interfaces\ProductVariantRepositoryInterface;
use App\Repositories\ProductImageRepository;
use App\Repositories\Interfaces\ProductImageRepositoryInterface;






class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderDetailRepositoryInterface::class, OrderDetailRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ShopRepositoryInterface::class, ShopRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductVariantRepositoryInterface::class, ProductVariantRepository::class);
        $this->app->bind(ProductImageRepositoryInterface::class, ProductImageRepository::class);
        $this->app->singleton(AppServices::class, function ($app) {
            return new AppServices(
                $app->make(ProductRepositoryInterface::class),
                $app->make(ProductVariantRepositoryInterface::class),
                $app->make(ProductImageRepositoryInterface::class)
            );
        });




    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
