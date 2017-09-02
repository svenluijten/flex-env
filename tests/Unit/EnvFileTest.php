<?php

namespace Sven\FlexEnv\Tests;

use Sven\FlexEnv\EnvFile;

class EnvFileTest extends TestCase
{
    /** @test */
    public function it_can_get_an_entry_by_its_key()
    {
        $env = new EnvFile();
        $env['APP_NAME'] = 'Flex-Env';
        $env['APP_DEBUG'] = 'true';

        $this->assertEquals('Flex-Env', $env->get('APP_NAME'));
        $this->assertEquals('true', $env->get('APP_DEBUG'));
    }

    /** @test */
    public function it_returns_the_default_value_if_it_is_not_present()
    {
        $env = new EnvFile();

        $this->assertEquals(null, $env->get('DOES_NOT_EXIST'));
        $this->assertEquals('default', $env->get('ALSO_NOT_THERE', 'default'));
    }

    /** @test */
    public function it_sets_a_value_on_the_instance()
    {
        $env = new EnvFile();

        $env->set('SOME_KEY', 'foobar');

        $this->assertEquals('foobar', $env->get('SOME_KEY'));
    }

    /** @test */
    public function it_unsets_a_value_on_the_instance()
    {
        $env = new EnvFile();

        $env->set('SOME_KEY', 'foobar');
        $env->unset('SOME_KEY');

        $this->assertArrayNotHasKey('SOME_KEY', $env);
    }

    /** @test */
    public function it_has_a_string_representation()
    {
        $env = new EnvFile();
        $env->set('SOME_KEY', 'some_value');

        $this->assertEquals('SOME_KEY=some_value'.PHP_EOL, (string) $env);
    }

    /** @test */
    public function it_wraps_a_value_in_quotes_if_it_contains_a_space()
    {
        $env = new EnvFile();
        $env->set('SOME_KEY', 'foo bar');

        $this->assertEquals('SOME_KEY="foo bar"'.PHP_EOL, (string) $env);
    }
}
