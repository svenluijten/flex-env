<?php

namespace Sven\FlexEnv\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

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

        if ($this->option('force') || $this->confirm("Are you sure you want to delete \"$key\" from your .env file?")) {
            $config->persist();

            $this->comment("Successfully deleted the entry \"$key\" from your .env file.");

            return 0;
        }

        $this->comment('Alright, no changes made.');

        return 1;
    }

    protected function getArguments()
    {
        return [
            ['key', InputArgument::REQUIRED, 'The name of the environment variable to delete.'],
        ];
    }

    protected function getOptions()
    {
        return [
            [
                'force',
                null,
                InputOption::VALUE_NONE,
                'Do not ask for confirmation before deleting the key from the environment file.',
            ],
        ];
    }
}
