<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Console\Command;
use Sven\FlexEnv\Env;

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

    public function handle(): void
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
}
