<?php

namespace Sven\FlexEnv\Tests;

class EnvTest extends EnvTestCase
{
    /** @test */
    public function it_creates_an_env_file_if_none_exists()
    {
        $this->assertEquals(
            __DIR__.'/assets/.env',
            $this->flex->getPath()
        );
    }

    /** @test */
    public function it_can_read_entries()
    {
        file_put_contents(__DIR__.'/assets/.env', 'TEST=hello-world');
        file_put_contents(__DIR__.'/assets/.env', "\nFOO_BAR=something else", FILE_APPEND);

        $this->assertEquals(
            'hello-world',
            $this->flex->get('TEST')
        );

        $this->assertEquals(
            'something else',
            $this->flex->get('FOO_BAR')
        );
    }

    /** @test */
    public function it_returns_an_empty_string_if_value_not_found()
    {
        $this->assertEquals('', $this->flex->get('I_DO_NOT_EXIST'));
    }

    /** @test */
    public function it_can_set_values()
    {
        $result = $this->flex->set('HELLO_WORLD', 'this-is-a-test')
                             ->get('HELLO_WORLD');

        $this->assertEquals(
            '"this-is-a-test"',
            $result
        );
    }

    /** @test */
    public function it_can_set_boolean_values()
    {
        $result = $this->flex->set('BOOLEAN_VALUE', true)
                            ->get('BOOLEAN_VALUE');

        $this->assertEquals('true', $result);
    }

    /** @test */
    public function it_removes_an_entry()
    {
        $result1 = $this->flex->set('FOO_BAR', 'biz-baz')
                              ->get('FOO_BAR');

        $this->assertEquals('"biz-baz"', $result1);

        $result2 = $this->flex->delete('FOO_BAR')
                              ->get('FOO_BAR');

        $this->assertEquals('', $result2);
    }

    /** @test */
    public function it_lists_all_entries()
    {
        $this->flex->set('TESTING', 'hello-world')
                   ->set('FOO_BAR', 'biz-baz');

        $this->assertEquals(
            ['TESTING' => '"hello-world"', 'FOO_BAR' => '"biz-baz"'],
            $this->flex->all()
        );
    }

    /** @test */
    public function it_can_set_values_with_spaces()
    {
        $result = $this->flex->set('HELLO_WORLD', 'hello world')
                             ->get('HELLO_WORLD');

        $this->assertEquals('"hello world"', $result);
    }

    /** @test */
    public function it_can_list_values_with_spaces()
    {
        $this->flex->set('HELLO_WORLD', 'hello world')
                   ->set('TEST_VARIABLE', 'test variable')
                   ->set('VARIABLE', 'variable');

        $this->assertEquals(
            ['HELLO_WORLD' => '"hello world"', 'TEST_VARIABLE' => '"test variable"', 'VARIABLE' => 'variable'],
            $this->flex->all()
        );
    }

    /** @test */
    public function it_can_set_values_with_special_characters()
    {
        $this->flex->set('MAIL_USERNAME', 'name@example.com')
            ->set('MAIL_PASSWORD', '==hy6^gGbS+==')
            ->set('MAIL_ENCRYPTION', 'tls');

        $this->assertEquals(
            ['MAIL_USERNAME' => '"name@example.com"', 'MAIL_PASSWORD' => '"==hy6^gGbS+=="', 'MAIL_ENCRYPTION' => 'tls'],
            $this->flex->all()
        );

        $this->assertEquals('
MAIL_USERNAME="name@example.com"
MAIL_PASSWORD="==hy6^gGbS+=="
MAIL_ENCRYPTION=tls', file_get_contents(__DIR__.'/assets/.env'));
    }
}
