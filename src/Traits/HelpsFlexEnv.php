<?php

namespace Sven\FlexEnv\Traits;

use Symfony\Component\Console\Exception\InvalidArgumentException;

trait HelpsFlexEnv
{
    /**
     * @var boolean
     */
    protected $error = false;

    /**
     * @var string
     */
    protected $oldValue;

    /**
     * @var string
     */
    protected $inputValue;

    /**
     * @var string
     */
    protected $inputKey;

    /**
     * Stop further execution of the command.
     *
     * @return mixed
     */
    private function withError()
    {
        $this->error = true;

        return $this;
    }

    /**
     * Checks if the .env file exists.
     *
     * @return mixed
     */
    protected function envExists()
    {
        $this->file = base_path('.env');
        if (! file_exists($this->file)) {
            $this->error('.env file not found.');

            return $this->withError();
        }

        return $this;
    }

    /**
     * Set the user input on the class.
     *
     * @return mixed
     */
    protected function setData()
    {
        $this->inputKey = strtoupper($this->argument('key'));
        $this->setInputValue()->setOldValue(env($this->inputKey));

        return $this;
    }

    protected function assureOldValue()
    {
        if ($this->oldValue === false || $this->oldValue === null) {
            $this->error("$this->inputKey is not set in your .env file, use env:new to set it.");

            return $this->withError();
        }

        return $this;
    }

    /**
     * Set the value that was given by the user.
     *
     * @return mixed
     */
    private function setInputValue()
    {
        try {
            $this->inputValue = $this->argument('value');
        } catch (InvalidArgumentException $e) {
            return $this;
        }

        return $this;
    }

    /**
     * Get the value in the .env file for the key the user gave.
     *
     * @return mixed
     */
    private function setOldValue($oldValue)
    {
        if (is_bool($oldValue)) {
            $oldValue ? 'true' : 'false';
        } elseif(is_null($oldValue)) {
            $oldValue = 'null';
        } else {
            $this->oldValue = $oldValue;
        }

        return $this;
    }

    /**
     * Does the command have an error?
     *
     * @return boolean
     */
    protected function hasError()
    {
        return $this->error;
    }
}