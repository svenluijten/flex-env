<?php

use Orchestra\Testbench\TestCase;
use Mockery as m;

class FlexEnvTest extends TestCase
{
    public function setUp()
    {
        $this->flexenv = new Sven\FlexEnv\EnvEditor(__DIR__.'/assets/.env');
    }

    /** @test */
    public function it_creates_env_file_if_none_exists()
    {
        @unlink(realpath(__DIR__.'/assets/.env'));

        $this->assertTrue($this->flexenv->fileExists());
    }

    /** @test */
    public function it_checks_if_env_file_exists()
    {
        $this->assertTrue($this->flexenv->fileExists());
    }

    /** @test */
    public function it_retrieves_a_value_from_the_env_file()
    {
        file_put_contents($this->flexenv->getFile(), 'TEST=foobar');
        file_put_contents($this->flexenv->getFile(), "\nONE=1one", FILE_APPEND);
        file_put_contents($this->flexenv->getFile(), "\n", FILE_APPEND);
        file_put_contents($this->flexenv->getFile(), "\nTWO=2two", FILE_APPEND);

        $this->assertEquals($this->flexenv->get('TEST'), 'foobar');
    }

    /** @test */
    public function it_adds_a_value_into_the_env_file()
    {
        $this->flexenv->set('THREE', '3three');
        $get = $this->flexenv->get('THREE');

        $this->assertEquals($get, '3three');
    }
}
