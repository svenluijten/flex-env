<?php

namespace Sven\FlexEnv\Tests;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Sven\FlexEnv\ServiceProvider;

abstract class TestCase extends AbstractPackageTestCase
{
    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return string
     */
    public function getServiceProviderClass($app)
    {
        return ServiceProvider::class;
    }
}
