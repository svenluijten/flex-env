<?php

namespace Sven\FlexEnv;

use Illuminate\Support\ServiceProvider;

class FlexEnvServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $app = $this->app;
        
        $app['env:set'] = function($app) {
            return new Commands\SetEnv();
        };

        $app['env:get'] = function($app) {
            return new Commands\GetEnv();
        };

        $app['env:delete'] = function($app) {
            return new Commands\DeleteEnv();
        };

        $app['env:list'] = function($app) {
            return new Commands\ListEnv();
        };

        $this->commands(
            'env:set',
            'env:get',
            'env:delete',
            'env:list'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
