<?php

namespace LTStream\Extension;


use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
//use Laravel\Lumen\Application as LumenApplication;

class LaravelServiceProvider extends  ServiceProvider
{
     /**
     * Booting the package.
     */
    public function boot()
    {
        $this->setupConfig();
    }
    
    /**
     * Register the service provider.
     */
    public function register()
    {

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
//            $this->app->configure('api_auth');
//        }
        $this->mergeConfigFrom($configSource, 'ltstream');
//        $this->commands([
//            Command::class,
//        ]);
    }



}
