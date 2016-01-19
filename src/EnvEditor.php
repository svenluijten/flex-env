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
    }

    /**
     * Get an entry from the .env file by key.
     *
     * @param  string $key
     *
     * @return string
     */
    public function get($key)
    {
        $env = $this->parseFile();

        $result = $env->filter(function ($value) use ($key) {
            return $value->first() == $key;
        })->first();

        return $result instanceof Collection ? $result->get(1) : $result;
    }

    /**
     * Set the value of the given key to the value supplied.
     *
     * @param  string $key
     * @param  string $value
     *
     * @return \Sven\FlexEnv\EnvEditor
     */
    public function set($key, $value)
    {
        $oldValue = $this->get($key);
        $path = $this->getPath();

        if (!is_null($oldValue)) {
            $this->replaceInFile("$key=$oldValue", "$key=$value");
        } else {
            file_put_contents($path, "\n$key=$value", FILE_APPEND);
        }

        return $this;
    }

    /**
     * Delete an entry from the .env file.
     *
     * @param  string $key
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

        $env->each(function ($value, $key) use (&$result) {
            return $result[$value->first()] = $value->get(1);
        });

        return $result;
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
     * @param  string  $old
     * @param  string  $new
     * @param  int $append
     *
     * @return void
     */
    public function replaceInFile($old, $new, $append = 0)
    {
        $contents = file_get_contents($this->getPath());
        $replaceWith = preg_replace("~\n?$old\n?~", "\n$new", $contents);

        file_put_contents($this->getPath(), $replaceWith, $append);
    }
}
