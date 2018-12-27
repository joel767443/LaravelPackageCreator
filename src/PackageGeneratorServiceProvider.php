<?php

namespace YoweliKachala\PackageGenerator;

use Illuminate\Support\ServiceProvider;

use YoweliKachala\PackageGenerator\Helpers\SetupHelper;

/**
 * Class PackageGeneratorServiceProvider
 * @package YoweliKachala\PackageGenerator
 */
class PackageGeneratorServiceProvider extends  ServiceProvider {

    protected $commands = [
        'YoweliKachala\PackageGenerator\Commands\SetupCommand'
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'PackageGenerator');

        SetupHelper::setupEnvFile();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }

}