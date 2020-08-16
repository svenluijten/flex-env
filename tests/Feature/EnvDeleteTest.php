<?php

namespace Sven\FlexEnv\Tests\Feature;

use Sven\FlexEnv\Tests\TestCase;

class EnvDeleteTest extends TestCase
{
    /** @test */
    public function it_can_delete_an_entry(): void
    {
        $this->setEnvironment(<<<'ENV'
            HELLO=world
            FOO=bar
            SOMETHING=else
            ENV
        );

        $this->artisan('env:delete FOO')
            ->expectsConfirmation('Are you sure you want to delete "FOO" from your .env file?', 'yes')
            ->expectsOutput('Successfully deleted the entry "FOO" from your .env file.')
            ->assertExitCode(0);

        $this->assertStringEqualsFile($this->app->environmentFilePath(), <<<'ENV'
            HELLO=world
            SOMETHING=else

            ENV
        );
    }

    /** @test */
    public function it_does_not_ask_for_confirmation_when_the_force_flag_is_supplied(): void
    {
        $this->setEnvironment(<<<'ENV'
            HELLO=world
            FOO=bar
            SOMETHING=else
            ENV
        );

        $this->artisan('env:delete FOO --force')
            ->expectsOutput('Successfully deleted the entry "FOO" from your .env file.')
            ->assertExitCode(0);

        $this->assertStringEqualsFile($this->app->environmentFilePath(), <<<'ENV'
            HELLO=world
            SOMETHING=else

            ENV
        );
    }

    /** @test */
    public function it_does_not_delete_the_entry_when_no_is_answered(): void
    {
        $this->setEnvironment(<<<'ENV'
            HELLO=world
            FOO=bar
            SOMETHING=else
            ENV
        );

        $this->artisan('env:delete FOO')
            ->expectsConfirmation('Are you sure you want to delete "FOO" from your .env file?', 'no')
            ->expectsOutput('Alright, no changes made.')
            ->assertExitCode(1);

        $this->assertStringEqualsFile($this->app->environmentFilePath(), <<<'ENV'
            HELLO=world
            FOO=bar
            SOMETHING=else
            ENV
        );
    }
}
