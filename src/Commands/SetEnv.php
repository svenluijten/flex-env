<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class SetEnv extends Command
{
    /** @var string */
    protected $name = 'env:set';

    /** @var string */
    protected $description = 'Set an environment key to the given value';

    public function handle(Env $env): void
    {
        $envPath = $this->laravel->environmentFilePath();

        $file = $env->load($envPath);
        $file->set('FOO', 'some-value');

        $file->persist();
    }

    protected function getArguments()
    {
        return [
            ['key', InputArgument::REQUIRED, 'The name of the environment variable to set.'],
            ['value', InputArgument::REQUIRED, 'The value to set the environment variable to.'],
        ];
    }
}
