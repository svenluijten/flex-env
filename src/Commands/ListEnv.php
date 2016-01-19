<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Console\Command;
use Sven\FlexEnv\EnvEditor;

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
    protected $description = 'Shows all the current entries in your .env file.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $env = new EnvEditor(base_path('.env'));
        $data = [];

        $this->info('Getting all values from your .env file...');

        foreach ($env->all() as $key => $value) {
            $data[] = [$key, $value];
        }

        return $this->table(['Key', 'Value'], $data);
    }
}
