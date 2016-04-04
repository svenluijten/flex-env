<?php

namespace Sven\FlexEnv;

use Illuminate\Support\Collection;

class EnvEditor
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $previous;

    /**
     * Instantiate the EnvEditor.
     *
     * @param string $path
     */
    public function __construct($path)
    {
        if (!file_exists($path)) {
            file_put_contents($path, '');
        }

        $this->path = $path;
        $this->previous = file_get_contents($path);
    }

    /**
     * Get an entry from the .env file by key.
     *
     * @param string $key
     *
     * @return string
     */
    public function get($key)
    {
        $env = $this->parseFile();

        $result = $env->filter(function (Collection $value) use ($key) {
            return $value->first() == $key;
        })->first();

        return $result instanceof Collection ? $result->get(1) : $result;
    }

    /**
     * Set the value of the given key to the value supplied.
     *
     * @param string $key
     * @param string $value
     * @param bool   $linebreak
     *
     * @return \Sven\FlexEnv\EnvEditor
     */
    public function set($key, $value, $linebreak = false)
    {
        $oldValue = $this->get($key);
        $new = $linebreak ? "\n$key=$value" : "$key=$value";

        if (!is_null($oldValue)) {
            return $this->replaceInFile("$key=$oldValue", $new);
        }

        file_put_contents($this->getPath(), "\n$new", FILE_APPEND);

        return $this;
    }

    /**
     * Delete an entry from the .env file.
     *
     * @param string $key
     *
     * @return \Sven\FlexEnv\EnvEditor
     */
    public function delete($key)
    {
        $old = $this->get($key);

        $this->replaceInFile("$key=$old", '');

        return $this;
    }

    /**
     * Gets all the key/value pairs from the .env file.
     *
     * @return array
     */
    public function all()
    {
        $env = $this->parseFile();
        $result = [];

        $env->each(function (Collection $value) use (&$result) {
            return $result[$value->first()] = $value->get(1);
        });

        return $result;
    }

    /**
     * Rolls the .env file back to the way it was before performing the command.
     *
     * @return \Sven\FlexEnv\EnvEditor
     */
    public function rollback()
    {
        file_put_contents($this->getPath(), $this->previous);

        return $this;
    }

    /**
     * Get the full path to the .env file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Parse the .env file contents for easier handling.
     *
     * @return \Illuminate\Support\Collection
     */
    private function parseFile()
    {
        $contents = file_get_contents($this->getPath());
        $lines = new Collection(explode("\n", $contents));
        $result = new Collection();

        $lines->filter(function ($value) {
            return $value;
        })->each(function ($value) use ($result) {
            $result->push(new Collection(explode('=', $value)));
        });

        return $result;
    }

    /**
     * Replace a part of the .env file.
     *
     * @param string $old
     * @param string $new
     * @param int    $append
     *
     * @return \Sven\FlexEnv\EnvEditor
     */
    public function replaceInFile($old, $new, $append = 0)
    {
        $contents = $this->previous;
        $replaceWith = preg_replace("~$old\n?~", "$new\n", $contents);

        file_put_contents($this->getPath(), $replaceWith, $append);

        return $this;
    }
}
