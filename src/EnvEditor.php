<?php

namespace Sven\FlexEnv;

use Illuminate\Support\Collection;

class EnvEditor
{
    /**
     * @var string
     */
    protected $file;

    /**
     * Instantiate the EnvEditor.
     *
     * @param string $path The full path to the .env file
     */
    public function __construct($path)
    {
        $this->createFile($path);
    }

    /**
     * Get the env file's location.
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Create an .env file if it does not exist yet.
     *
     * @param  string $path
     * @return \Sven\FlexEnv\EnvEditor
     */
    protected function createFile($path)
    {
        if (! $this->fileExists()) {
            file_put_contents($path, '');
        }

        $this->file = $path;

        return $this;
    }

    /**
     * Set an entry in the .env file.
     *
     * @param  string $key
     * @param  string $value
     * @return \Sven\FlexEnv\EnvEditor
     */
    public function set($key, $value)
    {
        if ( ! $this->get($key)) {
            return $this->edit($key, $value);
        }

        return $this->create($key, $value);
    }

    /**
     * Add a new entry to the .env file.
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    private function create($key, $value)
    {
        file_put_contents($this->getFile(), "\n$key=$value", FILE_APPEND);
    }

    /**
     * Edit an existing entry in the .env file.
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    private function edit($key, $value)
    {
        $oldValue = $this->get($key);
        $oldEntry = "$key=$oldValue";
        $newEntry = "$key=$value";

        $this->envReplace($oldEntry, $newEntry);
    }

    /**
     * Replace the contents in the .env file.
     *
     * @param  string $old
     * @param  string $new
     * @return void
     */
    private function envReplace($old, $new)
    {
        $contents = file_get_contents($this->getFile());
        $newContents = preg_replace("~\n?$old\n?~", $new, $contents);

        file_put_contents($this->getFile(), $newContents);
    }

    /**
     * Get one entry from the .env file.
     *
     * @param  string $searchBy
     * @return string
     */
    public function get($searchBy)
    {
        $items = $this->parseEnv();

        return $items->filter(function($value) use ($searchBy) {
            return $value->first() == $searchBy;
        })->first()->get(1);
    }

    /**
     * Parse the .env file for easier handling.
     *
     * @return \Illuminate\Support\Collection
     */
    private function parseEnv()
    {
        $array = explode("\n", file_get_contents($this->file));
        $items = new Collection($array);

        return $items->filter(function($value) {
            return $value == true;
        })->map(function($value) {
            return new Collection(explode('=', $value));
        });
    }

    /**
     * Check if the .env file exists.
     *
     * @return bool
     */
    public function fileExists()
    {
        return file_exists($this->getFile());
    }
}