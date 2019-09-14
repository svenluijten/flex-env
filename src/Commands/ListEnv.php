<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Support\Collection;

class ListEnv extends EnvCommand
{
    /** @var string */
    protected $name = 'env:list';

    /** @var string */
    protected $description = 'Shows all the current entries in your .env file';

    public function handle(): int
    {
        $config = $this->config();

        $data = Collection::make($config->all())
            ->reject(function ($value, $key) {
                return $value === '' || ! is_string($key);
            });

        $this->table(['Key', 'Value'], $data);

        return 0;
    }
}
