<?php

namespace App\Providers;

use App\Services\CategoryProductService;
use App\Services\Implementation\CategoryProductServiceImpl;
use App\Services\Implementation\ProductServiceImpl;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductService::class, ProductServiceImpl::class);
        $this->app->bind(CategoryProductService::class, CategoryProductServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // cek token expired by ability 'remember'
        Sanctum::authenticateAccessTokensUsing(function (PersonalAccessToken $token, $isValid) {
            if($isValid) return true;
            return $token->can('remember') && $token->created_at->gt(now()->subMonth());
        });
    }
}
