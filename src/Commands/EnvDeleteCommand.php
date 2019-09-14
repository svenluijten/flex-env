<?php

namespace Sven\FlexEnv\Commands;

use Symfony\Component\Console\Input\InputArgument;

class EnvDeleteCommand extends EnvCommand
{
    /** @var string */
    protected $name = 'env:delete';

    /** @var string */
    protected $description = 'Delete an entry from your .env file';

    public function handle(): int
    {
        $config = $this->config();

        $config->delete($key = $this->key());
        $config->persist();

        $this->comment("Successfully deleted the entry \"$key\" from your .env file.");

        return 0;
    }

    protected function getArguments()
    {
        return [
            ['key', InputArgument::REQUIRED, 'The name of the environment variable to delete.'],
        ];
    }
}
