<?php

namespace Sven\FlexEnv\Tests\Feature;

use Sven\FlexEnv\Tests\TestCase;

class EnvListTest extends TestCase
{
    /** @test */
    public function it_shows_all_values_in_a_table(): void
    {
        $this->setEnvironment(<<<'ENV'
            HELLO=world
            FOO=bar
            BAZ=qux
            SOMETHING_LONGER="contains spaces!"
            ENV
        );

        $this->artisan('env:list')
            ->expectsTable(['Key', 'Value'], [
                ['HELLO', 'world'],
                ['FOO', 'bar'],
                ['BAZ', 'qux'],
                ['SOMETHING_LONGER', 'contains spaces!'],
            ])
            ->assertExitCode(0);
    }

    /** @test */
    public function it_can_resolve_references_to_other_environment_variables_if_they_were_defined_before(): void
    {
        $this->setEnvironment(<<<'ENV'
            HELLO=world
            FOO=bar
            SOMETHING="hello, ${HELLO}"
            ENV
        );

        $this->artisan('env:list --resolve-references')
            ->expectsTable(['Key', 'Value'], [
                ['HELLO', 'world'],
                ['FOO', 'bar'],
                ['SOMETHING', 'hello, world'],
            ])
            ->assertExitCode(0);
    }
}
