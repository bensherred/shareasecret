<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
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
        Factory::guessFactoryNamesUsing(function (string $modelName) {
            return 'Database\\Factories\\' . class_basename($modelName) . 'Factory';
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::unguard();
        Model::preventLazyLoading(! app()->isProduction());
    }
}
