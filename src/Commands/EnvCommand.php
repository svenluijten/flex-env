<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Console\Command;
use Sven\FileConfig\Drivers\DotEnv;
use Sven\FileConfig\File;
use Sven\FileConfig\Store;

class EnvCommand extends Command
{
    protected function config(string $fileName = null): Store
    {
        $envPath = $this->laravel->environmentPath();

        $fileName = $fileName ?: $this->laravel->environmentFile();

        $file = new File($envPath.DIRECTORY_SEPARATOR.$fileName);

        return new Store($file, new DotEnv());
    }

    protected function key(): string
    {
        return mb_strtoupper($this->argument('key'));
    }
}
