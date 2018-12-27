<?php

namespace YoweliKachala\PackageGenerator;

use Illuminate\Support\ServiceProvider;

use YoweliKachala\PackageGenerator\Commands\SetupCommand;
use YoweliKachala\PackageGenerator\Helpers\SetupHelper;

/**
 * Class PackageGeneratorServiceProvider
 * @package YoweliKachala\PackageGenerator
 */
class PackageGeneratorServiceProvider extends  ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/routes.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'PackageGenerator');

        SetupHelper::setupEnvFile();

        if ($this->app->runningInConsole()) {
            $this->commands([
                SetupCommand::class
            ]);
        }
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