<?php

namespace Sven\FlexEnv\Commands;

use Illuminate\Console\Command;
use Sven\FlexEnv\Traits\HelpsFlexEnv;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DeleteEnvKey extends Command
{
    use HelpsFlexEnv;

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
    protected $description = 'Delete an entry from your .env file.';

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

        if ( ! $this->confirm("Are you sure you want to remove $this->inputKey with a value of $this->oldValue from your .env file?")) {
            return $this->info('Nothing in your .env file was changed.');
        }

        $content = file_get_contents($this->file);
        $newContent = preg_replace("~\s?$this->inputKey=$this->oldValue\s?~", '', $content);
        file_put_contents($this->file, $newContent);

        return $this->info("Successfully removed $this->inputKey from your .env file");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['key', InputArgument::REQUIRED, 'The key in your .env to delete.'],
        ];
    }
}