<?php

namespace Sven\FlexEnv;

use Sven\FlexEnv\Exceptions\EnvException;

class Env
{
    /** @var array */
    protected $contents;

    public function load(string $path)
    {
        if (! is_file($path)) {
            throw EnvException::fileNotFound($path);
        }

        $this->contents = file_get_contents($path);
    }

    public function get($key, $default = null)
    {
        $escaped = preg_quote($key);

        preg_match('/'.$escaped.'=(.+)/', $this->contents, $matches);

        return $matches[1] ?? $default;
    }
}
