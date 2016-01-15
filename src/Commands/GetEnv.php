<?php

namespace Sven\FlexEnv\Commands;

use Sven\FlexEnv\FlexEnv;
use Symfony\Component\Console\Input\InputArgument;

class DeleteEnv extends FlexEnv
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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        //
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