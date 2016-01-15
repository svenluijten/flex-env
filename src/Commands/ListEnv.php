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

        $this->envExists()->hasError() ? die : null;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {

        $contents = file_get_contents($this->file);
        $newContents = str_replace(
            "$this->inputKey=$this->oldValue", "$this->inputKey=$this->inputValue", $contents
        );

        file_put_contents($this->file, $newContents);

        return $this->info("Changed $this->inputKey to '$this->inputValue' in your env file.");
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