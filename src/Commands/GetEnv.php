<?php

namespace Sven\FlexEnv\Commands;

use Sven\FlexEnv\EnvEditor;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class GetEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:get {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get an entry from your .env file.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $env = new EnvEditor(base_path('.env'));
        $key = $this->argument('key');

        $this->info('Getting value for ' . $key . '...');

        $result = $env->get($key);

        if ($result == '' || is_null($result)) {
            return $this->error("Could not find a value for key $key in your .env file.");
        }

        return $this->info("The value for $key is $result.");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['key', InputArgument::REQUIRED, 'The key of the entry in your .env to retrieve.'],
        ];
    }
}
