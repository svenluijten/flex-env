<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Support\Collection;
use Sven\FileConfig\Store;
use Symfony\Component\Console\Input\InputOption;

class EnvListCommand extends EnvCommand
{
    /** @var string */
    protected $name = 'env:list';

    /** @var string */
    protected $description = 'Shows all the current entries in your environment file.';

    public function handle(): int
    {
        $config = $this->config();

        $data = Collection::make($config->all())
            ->reject(function ($value, $key) {
                return $value === '' || !is_string($key);
            })
            ->when($this->option('resolve-references'), $this->resolveReferences($config))
            ->map(function ($value, $key) {
                return [$key, $value];
            });

        $this->table(['Key', 'Value'], $data->toArray());

        return 0;
    }

    protected function getOptions()
    {
        return [
            ['resolve-references', 'r', InputOption::VALUE_NONE, 'Should references in the environment file be resolved?'],
        ];
    }

    protected function resolveReferences(Store $config): \Closure
    {
        return function (Collection $data) use ($config) {
            return $data->map(function ($value, $key) use ($config) {
                $newValue = preg_replace_callback('/\$\{(.+)\}/m', function (array $matches) use ($config) {
                    return $config->get($matches[1]);
                }, $value);

                $config->set($key, $newValue);

                return $newValue;
            });
        };
    }
}
