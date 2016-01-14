<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Console\Command;
use Sven\FlexEnv\Traits\HelpsFlexEnv;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SetEnvKey extends Command
{
    use HelpsFlexEnv;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:set {key} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set an environment key to the given value.';

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
        $this->envExists()->setData()->assureOldValue();
        $this->hasError() ? die : null;

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
            ['key', InputArgument::REQUIRED, 'The key in your .env to edit'],
            ['value', InputArgument::REQUIRED, 'The value to change it to'],
        ];
    }
}