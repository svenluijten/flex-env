<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Console\Command;
use Sven\FlexEnv\EnvEditor;
use Symfony\Component\Console\Input\InputArgument;

class SetEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:set {key} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set an environment key to the given value.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $env = new EnvEditor(base_path('.env'));
        $key = $this->argument('key');
        $value = $this->argument('value');

        $result = $env->set($key, $value)->get($key);

        if ($result !== $value) {
            return $this->error('Could not set the value in your .env file...');
        }

        return $this->info("Successfully set $key to $value in your .env file.");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['key', InputArgument::REQUIRED, 'The key to set in your .env file.'],
            ['value', InputArgument::REQUIRED, 'The value to set it to.'],
        ];
    }
}
