<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Console\Command;
use Sven\FlexEnv\EnvEditor;
use Symfony\Component\Console\Input\InputArgument;

class DeleteEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:delete {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an entry from your .env file.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $env = new EnvEditor(base_path('.env'));
        $key = $this->argument('key');

        $this->info('Deleting '.$key.'...');

        $result = $env->delete($key)->get($key);

        if ($result == '' || is_null($result)) {
            return $this->info("Successfully deleted the entry with key $key from your .env file.");
        }

        return $this->info("No value was found for $key in the .env file.");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['key', InputArgument::REQUIRED, 'The key of the entry in your .env to delete.'],
        ];
    }
}
