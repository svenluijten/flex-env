<?php


class EnvEditorTest extends Orchestra\Testbench\TestCase
{
    /** @test */
    public function it_creates_an_env_file_if_none_exists()
    {
        @unlink(__DIR__.'/assets/.env');

        $f = new Sven\FlexEnv\EnvEditor(__DIR__.'/assets/.env');

        $this->assertEquals(__DIR__.'/assets/.env', $f->getPath());
    }

    /** @test */
    public function it_can_read_entries()
    {
        $f = new Sven\FlexEnv\EnvEditor(__DIR__.'/assets/.env');

        file_put_contents(__DIR__.'/assets/.env', 'TEST=hello-world');
        file_put_contents(__DIR__.'/assets/.env', "\nFOO_BAR=something else", FILE_APPEND);

        $this->assertEquals('hello-world', $f->get('TEST'));
        $this->assertEquals('something else', $f->get('FOO_BAR'));
    }

    /** @test */
    public function it_returns_an_empty_string_if_value_not_found()
    {
        $f = new Sven\FlexEnv\EnvEditor(__DIR__.'/assets/.env');

        $this->assertEquals('', $f->get('I_DO_NOT_EXIST'));
    }

    /** @test */
    public function it_can_add_values()
    {
        $f = new Sven\FlexEnv\EnvEditor(__DIR__.'/assets/.env');

        $result = $f->set('HELLO_WORLD', 'this-is-a-test')
                    ->get('HELLO_WORLD');

        $this->assertEquals('this-is-a-test', $result);
    }

    /** @test */
    public function it_removes_an_entry()
    {
        $f = new Sven\FlexEnv\EnvEditor(__DIR__.'/assets/.env');

        $result1 = $f->set('FOO_BAR', 'biz-baz')
                     ->get('FOO_BAR');

        $this->assertEquals('biz-baz', $result1);

        $result2 = $f->delete('FOO_BAR')
                     ->get('FOO_BAR');

        $this->assertEquals('', $result2);
    }

    /** @test */
    public function it_lists_all_entries()
    {
        @unlink(__DIR__.'/assets/.env');

        $f = new Sven\FlexEnv\EnvEditor(__DIR__.'/assets/.env');

        $f->set('TESTING', 'hello-world')
          ->set('FOO_BAR', 'biz-baz');

        $this->assertEquals(
            ['TESTING' => 'hello-world', 'FOO_BAR' => 'biz-baz'],
            $f->all()
        );
    }
}
