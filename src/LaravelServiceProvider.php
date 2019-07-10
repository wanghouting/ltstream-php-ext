<?php

namespace LTStream\Extension;


use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use LTStream\Extension\Console\Commands\InstallCommand;
//use Laravel\Lumen\Application as LumenApplication;

class LaravelServiceProvider extends  ServiceProvider
{
        protected $commands = [
            InstallCommand::class,
        ];

     /**
     * Booting the package.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/Route/routes.php');
        $this->setupConfig();

    }
    
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $configSource = realpath(__DIR__ . '/config.php');
        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                $configSource => config_path('ltstream.php')
            ]);
        }
//        elseif ($this->app instanceof LumenApplication) {
//            $this->app->configure('ltstream');
//        }
        $this->mergeConfigFrom($configSource, 'ltstream');

    }

}
