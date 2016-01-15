<?php

namespace Sven\FlexEnv\Commands;

use Sven\FlexEnv\FlexEnv;
use Symfony\Component\Console\Input\InputArgument;

class ListEnv extends FlexEnv
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
            ['key', InputArgument::REQUIRED, 'The key in your .env to edit.'],
            ['value', InputArgument::REQUIRED, 'The value to change it to.'],
        ];
    }
}