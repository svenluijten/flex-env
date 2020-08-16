<?php

namespace Sven\FlexEnv\Tests\Feature;

use Sven\FlexEnv\Tests\TestCase;

class EnvGetTest extends TestCase
{
    /** @test */
    public function it_gets_an_existing_value_from_the_environment_file(): void
    {
        $this->setEnvironment(<<<ENV
            FOO=bar
            KEY=value
            BAZ=qux
            ENV
        );

        $this->artisan('env:get KEY')
            ->expectsOutput('value')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_warns_the_user_when_the_key_could_not_be_found(): void
    {
        $this->setEnvironment(<<<ENV
            HELLO=world
            ENV
        );

        $this->artisan('env:get KEY_DOES_NOT_EXIST')
            ->expectsOutput('Could not find a value for "KEY_DOES_NOT_EXIST" in your environment file.')
            ->assertExitCode(1);
    }

    /** @test */
    public function it_gets_values_with_special_characters(): void
    {
        $this->setEnvironment(<<<ENV
            KEY_ONE="value wrapped in quotes because it contains spaces"
            KEY_TWO="s0m*t#1n&"
            ENV
        );

        $this->artisan('env:get KEY_ONE')
            ->expectsOutput('"value wrapped in quotes because it contains spaces"')
            ->assertExitCode(0);

        $this->artisan('env:get KEY_TWO')
            ->expectsOutput('"s0m*t#1n&"')
            ->assertExitCode(0);
    }
}
