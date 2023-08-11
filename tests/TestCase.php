<?php

namespace Sven\FlexEnv\Tests;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sven\FlexEnv\ServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getEnvironmentSetUp($app): void
    {
        file_put_contents(__DIR__.'/assets/.env.test', '');

        $app->useEnvironmentPath(__DIR__.'/assets');
        $app->loadEnvironmentFrom('.env.test');

        $app->register(ServiceProvider::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        foreach (glob(__DIR__.'/assets/.env.*') as $file) {
            unlink($file);
        }
    }

    protected function setEnvironment(string $env)
    {
        file_put_contents($this->app->environmentFilePath(), $env);
    }
}
