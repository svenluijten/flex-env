<?php

use Mockery as m;

class FlexEnvTest extends Orchestra\Testbench\TestCase
{
    /** @test */
    public function it_checks_if_env_file_exists()
    {
        $flexenv = new Sven\FlexEnv\EnvEditor(__DIR__.'/assets/.env');

        $this->assertTrue($flexenv->fileExists());
    }

    /** @test */
    public function it_creates_env_file_if_none_exists()
    {
        @unlink(realpath(__DIR__.'/assets/.env'));

        $flexenv = new Sven\FlexEnv\EnvEditor(__DIR__.'/assets/.env');

        $this->assertTrue($flexenv->fileExists());
    }

    /** @test */
    public function it_gets_the_env_file()
    {
        $flexenv = new Sven\FlexEnv\EnvEditor(__DIR__.'/assets/.env');

        $file = $flexenv->getFile();

        $this->assertEquals(__DIR__.'/assets/.env', $file);
    }

    /** @test */
    public function it_retrieves_a_value_from_the_env_file()
    {
        $flexenv = new Sven\FlexEnv\EnvEditor(__DIR__.'/assets/.env');

        file_put_contents($flexenv->getFile(), 'TEST=foobar', FILE_APPEND);
        file_put_contents($flexenv->getFile(), "\nONE=1one", FILE_APPEND);
        file_put_contents($flexenv->getFile(), "\n", FILE_APPEND);
        file_put_contents($flexenv->getFile(), "\nTWO=2two", FILE_APPEND);

        $this->assertEquals('foobar', $flexenv->get('TEST'));
        $this->assertEquals('2two', $flexenv->get('TWO'));
    }

    /** @test */
    // public function it_adds_a_value_into_the_env_file()
    // {
    //     $flexenv = new Sven\FlexEnv\EnvEditor(__DIR__.'/assets/.env');

    //     $flexenv->set('THREE', '3three');
    //     $get = $flexenv->get('THREE');

    //     $this->assertEquals($get, 'THREE');
    // }
}
