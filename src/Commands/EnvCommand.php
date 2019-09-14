<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Console\Command;
use Sven\FileConfig\Drivers\Env;
use Sven\FileConfig\File;
use Sven\FileConfig\Store;

class EnvCommand extends Command
{
    protected function config(): Store
    {
        $envPath = $this->laravel->environmentFilePath();

        $file = new File($envPath);

        return new Store($file, new Env());
    }

    protected function key(): string
    {
        return mb_strtoupper($this->argument('key'));
    }

    protected function value(): string
    {
        $value = (string) $this->argument('value');

        if (preg_match('/[^a-z0-9-_]/', $value)) {
            $value = '"'.$value.'"';
        }

        return $value;
    }
}
