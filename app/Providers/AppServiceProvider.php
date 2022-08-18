<?php

namespace App\Providers;

use App\Models\Produto;
use App\Repositories\ProdutoRepositories;
use App\Repositories\ProdutoRepositoriesInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(produtoRepositoriesInterface::class, ProdutoRepositories::class);
        $this->app->bind(produtoRepositoriesInterface::class, function () {
            return new ProdutoRepositories(new Produto);
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
