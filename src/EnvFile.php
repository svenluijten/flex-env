<?php

namespace Sven\FlexEnv;

use ArrayAccess;
use Sven\FlexEnv\Traits\ArrayAccessible;

class EnvFile implements ArrayAccess
{
    use ArrayAccessible;

    /**
     * @param string|int $offset
     * @param mixed      $default
     *
     * @return mixed
     */
    public function get($offset, $default = null)
    {
        return $this[$offset] ?? $default;
    }

    /**
     * @param string|int $offset
     * @param string     $value
     */
    public function set($offset, $value): void
    {
        $this[$offset] = $value;
    }

    /**
     * @param string|int $offset
     */
    public function unset($offset): void
    {
        unset($this[$offset]);
    }

    public function __toString(): string
    {
        return array_reduce(array_keys($this->values), function ($carry, $key) {
            $value = $this->get($key);

            if (preg_match('/[^a-z0-9]/i', $value)) {
                $value = sprintf('"%s"', $value);
            }

            return $carry.$key.'='.$value.PHP_EOL;
        }, '');
    }
}
