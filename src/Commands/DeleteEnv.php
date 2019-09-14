<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Console\Command;
use Sven\FlexEnv\Env;

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
    protected $description = 'Delete an entry from your .env file';

    public function handle(): int
    {
        $env = new Env(base_path('.env'));
        $key = strtoupper($this->argument('key'));

        $result = $env->delete($key)->get($key);

        if ($result !== '' && ! is_null($result)) {
            $env->rollback();

            $this->comment("No value was found for \"$key\" in the .env file, nothing was changed.");

            return 1;
        }

        $this->comment("Successfully deleted the entry \"$key\" from your .env file.");

        return 0;
    }
}
