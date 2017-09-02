<?php

namespace Sven\FlexEnv;

use Sven\FlexEnv\Contracts\Parser;

class EnvParser implements Parser
{
    /**
     * @return \Sven\FlexEnv\EnvParser
     */
    public static function make()
    {
        return new self();
    }

    /**
     * @param string $env
     *
     * @return \Sven\FlexEnv\EnvFile
     */
    public function parse($env)
    {
        $lines = $this->removeEmptyLines(
            $this->splitIntoLines($env)
        );

        return array_reduce($lines, function (EnvFile $carry, $line) {
            list($key, $value) = LineParser::make()->parse($line);

            $carry[$key] = $value;

            return $carry;
        }, new EnvFile);
    }

    /**
     * @param string $env
     *
     * @return array
     */
    protected function splitIntoLines($env)
    {
        return explode(PHP_EOL, $env);
    }

    /**
     * @param array $lines
     *
     * @return array
     */
    protected function removeEmptyLines(array $lines)
    {
        return array_filter($lines, function ($line) {
            return !empty($line);
        });
    }
}
