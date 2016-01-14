<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Console\Command;
use Sven\FlexEnv\Traits\HelpsFlexEnv;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NewEnvKey extends Command
{
    use HelpsFlexEnv;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:new {key} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new key in your .env file.';

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
        $this->envExists()->setData();
        $this->hasError() ? die : null;

        if ($this->oldValue !== null) {
            $this->error("$this->inputKey is already set in your .env file.");
            $this->error("You can use env:set to edit the current value.");

            die;
        }

        $contents = file_get_contents($this->file) . "\n$this->inputKey=$this->inputValue";
        file_put_contents($this->file, $contents);

        return $this->info(
            "Successfully set $this->inputKey to $this->inputValue in your .env file"
        );
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