<?php

namespace Sven\FlexEnv\Tests;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Sven\FlexEnv\ServiceProvider;

abstract class TestCase extends AbstractPackageTestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return string
     */
    public function getServiceProviderClass($app)
    {
        return ServiceProvider::class;
    }

    protected function setUp(): void
    {
        parent::setUp();

        file_put_contents(__DIR__.'/assets/.env.test', '');

        $this->app->useEnvironmentPath(__DIR__.'/assets');
        $this->app->loadEnvironmentFrom('.env.test');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unlink(__DIR__.'/assets/.env.test');
    }

    protected function setEnvironment(string $env)
    {
        file_put_contents($this->app->environmentFilePath(), $env);
    }
}
