<?php

namespace Sven\FlexEnv\Tests;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Sven\FlexEnv\ServiceProvider;

abstract class TestCase extends AbstractPackageTestCase
{
    /**
     * @var string
     */
    protected $original;

    /**
     * Set up the test suite.
     */
    public function setUp()
    {
        parent::setUp();

        $this->app->useEnvironmentPath(__DIR__.'/fixture');

        $this->original = file_get_contents($this->app->environmentFilePath());
    }

    /**
     * Tear down the test suite.
     */
    public function tearDown()
    {
        file_put_contents($this->app->environmentFilePath(), $this->original);

        parent::tearDown();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return string
     */
    public function getServiceProviderClass($app)
    {
        return ServiceProvider::class;
    }
}
