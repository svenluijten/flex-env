<?php

namespace Sven\FlexEnv\Tests;

use Sven\FlexEnv\EnvFile;
use Sven\FlexEnv\EnvParser;

class EnvParserTest extends TestCase
{
    /** @test */
    public function it_parses_the_env_file(): void
    {
        $parser = new EnvParser();

        $parsed = $parser->parse(
            file_get_contents($this->app->environmentFilePath())
        );

        $this->assertArrayHasKey('APP_NAME', $parsed);
        $this->assertSame('Flex-Env', $parsed['APP_NAME']);
    }

    /** @test */
    public function it_returns_an_env_file_instance(): void
    {
        $parser = new EnvParser();

        $parsed = $parser->parse(
            file_get_contents($this->app->environmentFilePath())
        );

        $this->assertInstanceOf(EnvFile::class, $parsed);
    }
}
