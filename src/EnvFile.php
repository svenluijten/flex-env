<?php

namespace Sven\FlexEnv;

use Illuminate\Support\Str;
use Sven\FlexEnv\Traits\ArrayAccessible;

class EnvFile implements \ArrayAccess
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
     *
     * @return \Sven\FlexEnv\EnvFile
     */
    public function set($offset, $value)
    {
        $this[$offset] = $value;

        return $this;
    }

    /**
     * @param string|int $offset
     *
     * @return \Sven\FlexEnv\EnvFile
     */
    public function unset($offset)
    {
        unset($this[$offset]);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return array_reduce(array_keys($this->values), function ($carry, $key) {
            $value = $this->get($key);

            if (Str::contains($value, ' ')) {
                $value = sprintf('"%s"', $value);
            }

            return $carry.$key.'='.$value.PHP_EOL;
        }, '');
    }
}
