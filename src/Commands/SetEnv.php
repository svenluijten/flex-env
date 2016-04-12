<?php

namespace Sven\FlexEnv\Commands;

use Sven\FlexEnv\Env;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class SetEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:set
                            {key : The key to change or set.}
                            {value : The value to set the specified key to.}
                            {--L|line-break : Whether or not the command should insert a linebreak before the entry.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set an environment key to the given value';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $env = new Env(base_path('.env'));
        $key = strtoupper($this->argument('key'));
        $value = (string) $this->argument('value');
        $linebreak = (bool) $this->option('line-break');

        $result = $env->set($key, $value, $linebreak)->get($key);

        if ($result !== $value) {
            $env->rollback();

            return $this->error('Could not set the value in your .env file, reverting...');
        }

        return $this->comment("Successfully set [$key] to [$value] in your .env file.");
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
