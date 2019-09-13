<?php

namespace Sven\FlexEnv;

use Sven\FlexEnv\Contracts\Parser;

class EnvParser implements Parser
{
    public function parse(string $env): EnvFile
    {
        $lines = $this->removeEmptyLines(
            $this->splitIntoLines($env)
        );

        $parser = new LineParser();

        return array_reduce($lines, function (EnvFile $file, $line) use ($parser) {
            [$key, $value] = $parser->parse($line);

            $file->set($key, $value);

            return $file;
        }, new EnvFile);
    }

    protected function splitIntoLines(string $env): array
    {
        return explode(PHP_EOL, $env);
    }

    protected function removeEmptyLines(array $lines): array
    {
        return array_filter($lines);
    }
}
