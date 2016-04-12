<?php

namespace Sven\FlexEnv\Commands;

use Sven\FlexEnv\Env;
use Illuminate\Console\Command;

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

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $env = new Env(base_path('.env'));
        $data = [];

        foreach ($env->all() as $key => $value) {
            $data[] = [$key, $value];
        }

        return $this->table(['Key', 'Value'], $data);
    }
}
