<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Support\Collection;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class EnvSyncCommand extends EnvCommand
{
    /** @var string */
    protected $name = 'env:sync';

    /** @var string */
    protected $description = 'Add keys that are present in the "example" file to the environment file.';

    public function handle(): int
    {
        $example = $this->config($this->argument('file'));
        $exampleValues = $example->all();

        $real = $this->config();
        $realValues = $real->all();

        $missingKeys = array_diff_key($exampleValues, $realValues);

        foreach ($missingKeys as $missingKey => $exampleValue) {
            $real->set($missingKey, $exampleValue);
        }

        if ($this->option('dry-run')) {
            $table = Collection::make($real->all())
                ->map(function ($value, $key) {
                    return [$key, $value];
                })
                ->toArray();

            $this->info('This would add the following variables to the environment file:');
            $this->table(['Key', 'Value'], $table);
            $this->info('Run with "--force" to make these changes.');

            return 0;
        }

        if ($this->option('force') || $this->confirm('Do you want to add '.count($missingKeys).' new variables to the environment file?')) {
            $real->persist();

            return 0;
        }

        $this->info('Alright, no changes made.');

        return 1;
    }

    public function getArguments()
    {
        return [
            ['file', InputArgument::OPTIONAL, 'The name of the example file to use.', '.env.example'],
        ];
    }

    protected function getOptions()
    {
        return [
            [
                'force',
                null,
                InputOption::VALUE_NONE,
                'Do not ask for confirmation before synchronizing the environment files.',
            ],
            [
                'dry-run',
                null,
                InputOption::VALUE_NONE,
                'Only show the values that would be added to the environment file.',
            ],
        ];
    }
}
