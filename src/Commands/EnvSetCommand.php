<?php

namespace Sven\FlexEnv\Commands;

use Symfony\Component\Console\Input\InputArgument;

class EnvSetCommand extends EnvCommand
{
    /** @var string */
    protected $name = 'env:set';

    /** @var string */
    protected $description = 'Set an environment variable to the given value.';

    public function handle(): int
    {
        $config = $this->config();

        $config->set($key = $this->key(), $this->value());
        $config->persist();

        $this->info("Successfully set the value for \"$key\" in the environment file.");

        return 0;
    }

    protected function value(): string
    {
        $value = (string) $this->argument('value') ?: $this->ask('What should the new value be?');

        if (preg_match('/[^a-z0-9-_]/', $value) === 1) {
            $value = '"'.$value.'"';
        }

        return $value;
    }

    protected function getArguments()
    {
        return [
            ['key', InputArgument::REQUIRED, 'The name of the environment variable to set.'],
            ['value', InputArgument::OPTIONAL, 'The value to set the environment variable to.', null],
        ];
    }
}
