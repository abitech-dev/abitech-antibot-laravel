<?php

namespace Abitech\AntiBot\Tests;

use Abitech\AntiBot\AntiBotServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            AntiBotServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'AntiBot' => \Abitech\AntiBot\Facades\AntiBot::class,
        ];
    }
}
