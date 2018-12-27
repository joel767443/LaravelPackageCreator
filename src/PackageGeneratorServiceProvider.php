<?php

namespace YoweliKachala\PackageGenerator;

use Illuminate\Support\ServiceProvider;

class PackageGeneratorServiceProvider extends  ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'PackageGenerator');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

}