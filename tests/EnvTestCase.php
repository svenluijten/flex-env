<?php

namespace Sven\FlexEnv\Tests;

use Sven\FlexEnv\Env;
use Sven\FlexEnv\FlexEnvServiceProvider;
use GrahamCampbell\TestBench\AbstractPackageTestCase;

abstract class EnvTestCase extends AbstractPackageTestCase
{
    /**
     * Set up the testing suite.
     */
    public function setUp()
    {
        mkdir(__DIR__.'/assets');

        $this->flex = new Env(__DIR__.'/assets/.env');
    }

    /**
     * Tear down the testing suite.
     */
    public function tearDown()
    {
        $directory = realpath(__DIR__.'/assets');

        $iterator = new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($files as $file) {
            $file->isDir() ?
                rmdir($file->getRealPath()) :
                unlink($file->getRealPath());
        }

        rmdir($directory);
    }
}
