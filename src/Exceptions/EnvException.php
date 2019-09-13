<?php

namespace Sven\FlexEnv\Exceptions;

use RuntimeException;

class EnvException extends RuntimeException
{
    public static function fileNotFound(string $path)
    {
        return new self('No such file "'.$path.'"');
    }
}
