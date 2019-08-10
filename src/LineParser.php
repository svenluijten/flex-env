<?php

namespace Sven\FlexEnv;

use Illuminate\Support\Str;
use Sven\FlexEnv\Contracts\Parser;
use Sven\FlexEnv\Exceptions\UnparsableException;

class LineParser implements Parser
{
    public function parse(string $line): array
    {
        if (! Str::contains($line, '=')) {
            throw UnparsableException::invalidLineSignature($line);
        }

        [$key, $value] = explode('=', $line);

        if (Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            $value = trim($value, '"');
        }

        return [$key, $value];
    }
}
