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
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            Commands\SetEnv::class,
            Commands\GetEnv::class,
            Commands\DeleteEnv::class,
            Commands\ListEnv::class,
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Commands\SetEnv::class,
            Commands\GetEnv::class,
            Commands\DeleteEnv::class,
            Commands\ListEnv::class,
        ];
    }
}
