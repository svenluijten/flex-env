<?php

namespace Sven\FlexEnv\Tests;

use Sven\FlexEnv\EnvEditor;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    /**
     * The EnvEditor instance.
     *
     * @var \Sven\FlexEnv\EnvEditor
     */
    protected $flex;

    /**
     * Set up the testing suite.
     */
    public function setUp()
    {
        $this->flex = new EnvEditor(__DIR__.'/assets/.env');
    }

    /**
     * Tear down the testing suite.
     */
    public function tearDown()
    {
        unlink(__DIR__.'/assets/.env');
    }
}
