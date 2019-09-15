<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Sven\FileConfig\Drivers\Env;
use Symfony\Component\Console\Input\InputArgument;

class EnvExampleCommand extends EnvCommand
{
    /** @var string */
    protected $name = 'env:example';

    /** @var string */
    protected $description = 'Generate an "example" environment file for distribution.';

    public function handle(Filesystem $files): int
    {
        $config = $this->config();

        $values = Collection::make($config->all())
            ->mapWithKeys(function ($value, $key) {
                if (is_numeric($key) && $value === '') {
                    return [$key => $value];
                }

                return [$key => ''];
            })
            ->toArray();

        $contents = (new Env())->export($values);
        $file = $this->laravel->environmentPath().DIRECTORY_SEPARATOR.$this->argument('name');

        $files->put($file, $contents);

        return 0;
    }

    public function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, 'The name of the "example" file to generate.', '.env.example'],
        ];
    }
}
