<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Console\Command;
use Sven\FlexEnv\Env;

class ListEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows all the current entries in your .env file';

    public function handle(): int
    {
        $env = new Env(base_path('.env'));
        $data = [];

        foreach ($env->all() as $key => $value) {
            $data[] = [$key, $value];
        }

        $this->table(['Key', 'Value'], $data);

        return 0;
    }
}
