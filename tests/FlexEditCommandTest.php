<?php

use Mockery as m;

class FlexEditCommandTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /** @test */
    public function test_get_item_from_env_file()
    {
        $cmd = m::mock('\Sven\FlexEnv\Commands\GetEnv[argument]');

        $cmd->shouldReceive('argument')
            ->with('TESTING')
            ->once()
            ->andReturn('hello-world');

        $output = $cmd->handle();

        $this->assertEquals('hello-world', $output);
    }

}
