<?php

namespace Sven\FlexEnv\Commands;

use Symfony\Component\Console\Input\InputArgument;

class GetEnv extends EnvCommand
{
    /** @var string */
    protected $name = 'env:get';

    /** @var string */
    protected $description = 'Get an entry from your .env file';

    public function handle(): int
    {
        $config = $this->config();

        $value = $config->get($key = $this->key());

        if ($value === null) {
            $this->error("Could not find a value for \"$key\" in your .env file.");

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
