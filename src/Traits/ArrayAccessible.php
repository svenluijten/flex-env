<?php

namespace Sven\FlexEnv\Traits;

trait ArrayAccessible
{
    /**
     * @var array
     */
    protected $values = [];

    /**
     * @return string
     */
    protected function getValuesPropertyName()
    {
        return 'values';
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->values[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->values[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->values[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->values[$offset]);
    }
}
