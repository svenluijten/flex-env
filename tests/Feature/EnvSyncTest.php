<?php

namespace Sven\FlexEnv\Tests\Feature;

use Sven\FlexEnv\Tests\TestCase;

class EnvSyncTest extends TestCase
{
    /** @test */
    public function it_can_show_the_changes_it_would_make_in_a_dry_run(): void
    {
        $this->setEnvironment(<<<'ENV'
            FOO=bar
            ENV
        );

        file_put_contents($this->app->environmentPath().DIRECTORY_SEPARATOR.'.env.example', <<<'ENV'
            FOO=
            I_AM_NEW=
            ENV
        );

        $this->artisan('env:sync', ['--dry-run' => true])
            ->expectsOutput('This would add the following variables to the environment file:')
            ->expectsTable(['Key', 'Value'], [['I_AM_NEW', '']])
            ->expectsOutput('Run without "--dry-run" to make these changes.')
            ->assertExitCode(0);
    }

    /** @test */
    public function if_neither_dry_run_or_force_option_is_given_it_does_nothing(): void
    {
        $this->setEnvironment(<<<'ENV'
            FOO=bar
            ENV
        );

        file_put_contents($this->app->environmentPath().DIRECTORY_SEPARATOR.'.env.example', <<<'ENV'
            FOO=
            I_AM_NEW=
            ENV
        );

        $this->artisan('env:sync')
            ->expectsConfirmation('Do you want to add 1 new variables to the environment file?', 'no')
            ->expectsOutput('Alright, no changes made.')
            ->assertExitCode(1);

        $this->assertStringEqualsFile($this->app->environmentFilePath(), <<<'ENV'
            FOO=bar
            ENV
        );
    }

    /** @test */
    public function it_inserts_new_values_into_the_environment_file_without_overwriting_already_existing_values(): void
    {
        $this->setEnvironment(<<<'ENV'
            FOO=bar
            ENV
        );

        file_put_contents($this->app->environmentPath().DIRECTORY_SEPARATOR.'.env.example', <<<'ENV'
            FOO=
            I_AM_NEW="this is a test value"
            ENV
        );

        $this->artisan('env:sync', ['--force' => true])
            ->assertExitCode(0);

        $this->assertStringEqualsFile($this->app->environmentFilePath(), <<<'ENV'
            FOO=bar
            I_AM_NEW="this is a test value"

            ENV
        );
    }
}
