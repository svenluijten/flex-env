<?php

namespace Sven\FlexEnv\Tests\Unit;

use Sven\FlexEnv\Env;
use Sven\FlexEnv\Exceptions\EnvException;
use Sven\FlexEnv\Tests\TestCase;

class EnvTest extends TestCase
{
    /** @test */
    public function it_cannot_load_a_non_existing_environment_file(): void
    {
        $env = new Env();

        $file = __DIR__.'/../fixtures/.env.does-not-exist';

        $this->expectException(EnvException::class);
        $this->expectExceptionMessage('No such file "'.$file.'"');

        $env->load($file);
    }

    /** @test */
    public function it_can_read_from_an_environment_file(): void
    {
        $env = new Env();
        $env->load(__DIR__.'/../fixtures/.env.one-entry');

        $this->assertEquals('pong', $env->get('PING'));
        $this->assertNull($env->get('PANG'));
        $this->assertEquals('default', $env->get('PUNG', 'default'));
    }
}
