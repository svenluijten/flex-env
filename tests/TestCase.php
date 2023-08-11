<?php

namespace Sven\FlexEnv\Tests;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Sven\FlexEnv\ServiceProvider;

abstract class TestCase extends AbstractPackageTestCase
{
    public static function getServiceProviderClass(): string
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

        foreach (glob(__DIR__.'/assets/.env.*') as $file) {
            unlink($file);
        }
    }

    protected function setEnvironment(string $env)
    {
        file_put_contents($this->app->environmentFilePath(), $env);
    }
}
