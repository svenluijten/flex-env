<?php

namespace Sven\FlexEnv\Tests\Feature;

use Sven\FlexEnv\Tests\TestCase;

class EnvExampleTest extends TestCase
{
    /** @test */
    public function it_generates_an_example_file_with_empty_values(): void
    {
        $this->setEnvironment(<<<'ENV'
            APP_NAME="Some Name Here"
            APP_LOCALE=en_US

            DB_USERNAME=root
            DB_PASSWORD=root
            DB_HOST=localhost
            ENV
        );

        $this->artisan('env:example')
            ->assertExitCode(0);

        $examplePath = $this->app->environmentPath().DIRECTORY_SEPARATOR.'.env.example';
        $this->assertFileExists($examplePath);
        $this->assertStringEqualsFile($examplePath, <<<'ENV'
            APP_NAME=
            APP_LOCALE=
            
            DB_USERNAME=
            DB_PASSWORD=
            DB_HOST=

            ENV
        );
    }

    /** @test */
    public function it_preserves_comments_when_generating_example_environment_file(): void
    {
        $this->setEnvironment(<<<'ENV'
            # Application Settings
            APP_NAME="Some Name Here"
            APP_LOCALE=en_US

            # Database
            DB_USERNAME=root
            DB_PASSWORD=root
            DB_HOST=localhost
            ENV
        );

        $this->artisan('env:example');

        $examplePath = $this->app->environmentPath().DIRECTORY_SEPARATOR.'.env.example';
        $this->assertStringEqualsFile($examplePath, <<<'ENV'
            # Application Settings
            APP_NAME=
            APP_LOCALE=

            # Database
            DB_USERNAME=
            DB_PASSWORD=
            DB_HOST=

            ENV
        );
    }
}
