<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Console\Command;
use Sven\FileConfig\Drivers\Env;
use Sven\FileConfig\File;
use Sven\FileConfig\Store;
use Symfony\Component\Console\Input\InputArgument;

class SetEnv extends Command
{
    /** @var string */
    protected $name = 'env:set';

    /** @var string */
    protected $description = 'Set an environment key to the given value';

    public function handle(): int
    {
        $envPath = $this->laravel->environmentFilePath();

        $file = new File($envPath);
        $config = new Store($file, new Env());

        $config->set(
            $this->argument('key'),
            $this->argument('value')
        );

        $config->persist();

        $this->info('Successfully set the value in the .env file.');

        return 0;
    }

    protected function getArguments()
    {
        return [
            ['key', InputArgument::REQUIRED, 'The name of the environment variable to set.'],
            ['value', InputArgument::REQUIRED, 'The value to set the environment variable to.'],
        ];
    }
}
