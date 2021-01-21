<?php

namespace Sven\FlexEnv\Tests\Feature;

use Sven\FlexEnv\Tests\TestCase;

class EnvSetTest extends TestCase
{
    /** @test */
    public function it_can_set_a_value_in_an_empty_environment_file(): void
    {
        $this->artisan('env:set KEY value')
            ->expectsOutput('Successfully set the value for "KEY" in the environment file.')
            ->assertExitCode(0);

        $this->assertStringEqualsFile($this->app->environmentFilePath(), <<<'ENV'
            KEY=value
            
            ENV
        );
    }

    /** @test */
    public function it_can_change_an_existing_value(): void
    {
        $this->setEnvironment(<<<'ENV'
            FOO=bar
            HELLO=world
            BAZ=qux
            ENV
        );

        $this->artisan('env:set HELLO "everybody"')
            ->expectsOutput('Successfully set the value for "HELLO" in the environment file.')
            ->assertExitCode(0);

        $this->artisan('env:set BAZ "something with spaces"')
            ->expectsOutput('Successfully set the value for "BAZ" in the environment file.')
            ->assertExitCode(0);

        $this->assertStringEqualsFile($this->app->environmentFilePath(), <<<'ENV'
            FOO=bar
            HELLO=everybody
            BAZ="something with spaces"

            ENV
        );
    }

    /** @test */
    public function it_asks_for_the_new_value(): void
    {
        $this->setEnvironment(<<<'ENV'
            HELLO=world
            ENV
        );

        $this->artisan('env:set HELLO')
            ->expectsQuestion('What should the new value be?', 'universe')
            ->expectsOutput('Successfully set the value for "HELLO" in the environment file.')
            ->assertExitCode(0);

        $this->assertStringEqualsFile($this->app->environmentFilePath(), <<<'ENV'
            HELLO=universe

            ENV
        );
    }
}
