<?php

namespace Sven\FlexEnv\Commands;

use Symfony\Component\Console\Input\InputArgument;

class EnvSetCommand extends EnvCommand
{
    /** @var string */
    protected $name = 'env:set';

    /** @var string */
    protected $description = 'Set an environment key to the given value';

    public function handle(): int
    {
        $config = $this->config();

        $config->set($key = $this->key(), $this->value());
        $config->persist();

        $this->info("Successfully set the value for \"$key\" in the .env file.");

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
