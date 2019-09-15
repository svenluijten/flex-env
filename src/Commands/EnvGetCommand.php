<?php

namespace Sven\FlexEnv\Commands;

use Symfony\Component\Console\Input\InputArgument;

class EnvGetCommand extends EnvCommand
{
    /** @var string */
    protected $name = 'env:get';

    /** @var string */
    protected $description = 'Get an entry from your environment file.';

    public function handle(): int
    {
        $config = $this->config();

        $value = $config->get($key = $this->key());

        if ($value === null) {
            $this->error("Could not find a value for \"$key\" in your environment file.");

            return 1;
        }

        $this->line($value);

        return 0;
    }

    protected function getArguments()
    {
        return [
            ['key', InputArgument::REQUIRED, 'The name of the environment variable to get.'],
        ];
    }
}
