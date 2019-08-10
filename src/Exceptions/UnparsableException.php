<?php

namespace Sven\FlexEnv\Exceptions;

use InvalidArgumentException;

class UnparsableException extends InvalidArgumentException
{
    public static function invalidLineSignature($actual): self
    {
        return new self(
            'The line could not be parsed. Found "'.$actual.'", expected `{STRING}={STRING}` or `{STRING}="{STRING}"`.'
        );
    }
}
