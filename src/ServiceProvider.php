<?php

namespace Sven\FlexEnv;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider implements DeferrableProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Commands\EnvSetCommand::class,
            Commands\EnvGetCommand::class,
            Commands\EnvDeleteCommand::class,
            Commands\EnvListCommand::class,
            Commands\EnvExampleCommand::class,
            Commands\EnvSyncCommand::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            Commands\EnvSetCommand::class,
            Commands\EnvGetCommand::class,
            Commands\EnvDeleteCommand::class,
            Commands\EnvListCommand::class,
            Commands\EnvExampleCommand::class,
            Commands\EnvSyncCommand::class,
        ];
    }
}
