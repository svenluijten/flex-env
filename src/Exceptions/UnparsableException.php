<?php

namespace Sven\FlexEnv\Exceptions;

use InvalidArgumentException;

class UnparsableException extends InvalidArgumentException
{
    public static function invalidLineSignature($actual)
    {
        return new self(
            sprintf(
                'The line could not be parsed. Found "%s", expected `{STRING}={STRING}` or `{STRING}="{STRING}"`.',
                $actual
            )
        );
    }
}
