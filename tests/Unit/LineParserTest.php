<?php

namespace Sven\FlexEnv\Tests;

use Sven\FlexEnv\Exceptions\UnparsableException;
use Sven\FlexEnv\LineParser;

class LineParserTest extends TestCase
{
    /** @test */
    public function it_parses_a_single_line()
    {
        list($key, $value) = LineParser::make()->parse('APP_URL=some-value');

        $this->assertEquals('APP_URL', $key);
        $this->assertEquals('some-value', $value);
    }

    /** @test */
    public function it_parses_an_empty_value_as_empty_string()
    {
        list(, $value) = LineParser::make()->parse('APP_KEY=');

        $this->assertEquals('', $value);
    }

    /** @test */
    public function it_removes_double_quotes_from_around_a_value()
    {
        list(, $value) = LineParser::make()->parse('APP_KEY="some value with spaces"');

        $this->assertEquals('some value with spaces', $value);
    }

    /** @test */
    public function it_does_not_remove_double_quotes_if_the_value_just_starts_or_begins_with_one()
    {
        list(, $value1) = LineParser::make()->parse('APP_KEY="foo-bar');
        list(, $value2) = LineParser::make()->parse('APP_KEY=foo-bar"');

        $this->assertEquals('"foo-bar', $value1);
        $this->assertEquals('foo-bar"', $value2);
    }

    /** @test */
    public function it_throws_an_exception_if_the_line_signature_is_invalid()
    {
        $this->expectException(UnparsableException::class);

        LineParser::make()->parse('something silly');
    }
}
