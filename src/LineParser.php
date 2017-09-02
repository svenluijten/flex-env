<?php

namespace Sven\FlexEnv;

use Illuminate\Support\Str;
use Sven\FlexEnv\Contracts\Parser;
use Sven\FlexEnv\Exceptions\UnparsableException;

class LineParser implements Parser
{
    /**
     * @return \Sven\FlexEnv\LineParser
     */
    public static function make()
    {
        return new self();
    }

    /**
     * @param string $line
     *
     * @return array
     */
    public function parse($line)
    {
        if (! Str::contains($line, '=')) {
            throw UnparsableException::invalidLineSignature($line);
        }

        list($key, $value) = explode('=', $line);

        if (Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            $value = trim($value, '"');
        }

        return [$key, $value];
    }
}
