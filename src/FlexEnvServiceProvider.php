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
        $this->app['env:set'] = $this->app->share(function() {
            return new Commands\SetEnv;
        });

        $this->app['env:delete'] = $this->app->share(function() {
            return new Commands\DeleteEnv;
        });

        $this->app['env:list'] = $this->app->share(function() {
            return new Commands\ListEnv;
        });

        $this->commands(
            'env:set',
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
