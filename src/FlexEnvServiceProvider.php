<?php

namespace Sven\FlexEnv;

use Illuminate\Support\ServiceProvider;

class FlexEnvServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['env:set'] = $this->app->share(function() {
            return new Commands\SetEnvKey;
        });

        $this->app['env:new'] = $this->app->share(function() {
            return new Commands\NewEnvKey;
        });

        $this->app['env:delete'] = $this->app->share(function() {
            return new Commands\DeleteEnvKey;
        });

        $this->commands(
            'env:set',
            'env:new',
            'env:delete'
        );
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}