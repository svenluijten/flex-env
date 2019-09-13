<?php

namespace Sven\FlexEnv\Tests;

use Sven\FlexEnv\EnvFile;

class EnvFileTest extends TestCase
{
    /** @test */
    public function it_can_get_an_entry_by_its_key(): void
    {
        $env = new EnvFile();
        $env['APP_NAME'] = 'Flex-Env';
        $env['APP_DEBUG'] = 'true';

        $this->assertEquals('Flex-Env', $env->get('APP_NAME'));
        $this->assertEquals('true', $env->get('APP_DEBUG'));
    }

    /** @test */
    public function it_returns_the_default_value_if_it_is_not_present(): void
    {
        $env = new EnvFile();

        $this->assertEquals(null, $env->get('DOES_NOT_EXIST'));
        $this->assertEquals('default', $env->get('ALSO_NOT_THERE', 'default'));
    }

    /** @test */
    public function it_sets_a_value_on_the_instance(): void
    {
        $env = new EnvFile();
        $env->set('SOME_KEY', 'foobar');

        $this->assertEquals('foobar', $env->get('SOME_KEY'));
    }

    /** @test */
    public function it_unsets_a_value_on_the_instance(): void
    {
        $env = new EnvFile();
        $env->set('SOME_KEY', 'foobar');

        $env->unset('SOME_KEY');

        $this->assertArrayNotHasKey('SOME_KEY', $env);
    }

    /** @test */
    public function it_has_a_string_representation(): void
    {
        $env = new EnvFile();
        $env->set('SOME_KEY', 'foobar');

        $this->assertEquals('SOME_KEY=foobar'.PHP_EOL, (string) $env);
    }

    /** @test */
    public function it_wraps_a_value_in_quotes_if_it_contains_non_alphanumerical_characters(): void
    {
        $env = new EnvFile();

        $nonAlphanum = str_split("!@#$%^*()_+~`=-'\"\\;:<>.,/? ");

        foreach ($nonAlphanum as $key => $character) {
            $env->set('NON_ALPHANUM_'.($key + 1), 'some'.$character.'value');
        }

        foreach ($nonAlphanum as $key => $character) {
            $this->assertStringContainsString('NON_ALPHANUM_'.($key + 1).'="some'.$character.'value"', (string) $env);
        }
    }
}
