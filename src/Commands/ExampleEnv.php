<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Console\Command;
use Sven\FlexEnv\Env;

class ExampleEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:example
                           {--name=.env.example : Name of the example environment file }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an environment file for distribution';

    public function handle(): int
    {
        $env = new Env(base_path('.env'));

        $name = (string) $this->option('name');

        try {
            $env->copy(
                base_path($name, Env::COPY_FOR_DISTRIBUTION)
            );

            return $this->comment("Successfully created the file [$name]");
        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return 1;
        }

        return 0;
    }
}
