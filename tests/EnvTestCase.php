<?php

namespace Sven\FlexEnv\Tests;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Sven\FlexEnv\Env;

abstract class EnvTestCase extends AbstractPackageTestCase
{
    public function setUp(): void
    {
        mkdir(__DIR__.'/assets');

        $this->flex = new Env(__DIR__.'/assets/.env');
    }

    public function tearDown(): void
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
